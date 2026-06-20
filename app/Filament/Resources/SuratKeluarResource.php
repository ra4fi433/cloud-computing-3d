<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SuratKeluarResource\Pages;
use App\Filament\Resources\SuratKeluarResource\RelationManagers;
use App\Models\SuratKeluar;
use App\Models\Bidang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
// use App\Filament\Resources\Auth;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\View; // Import View component
// use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\KlasifikasiSurat;
use Carbon\Carbon;

// controller Surat Keluar untuk superadmin
class SuratKeluarResource extends Resource
{
    protected static ?string $model = SuratKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Surat Keluar';

    protected static ?string $modelLabel = 'Surat Keluar';

    protected static ?string $pluralModelLabel = 'Surat Keluar';

    public static function form(Form $form): Form
    {
        $bidangOptions = Bidang::orderBy('id')->pluck('nama_bidang', 'id')->toArray();
        return $form
            ->schema([
                // Forms\Components\TextInput::make('nomor_urut')
                // ->label('Nomor Urut')
                // ->disabled()
                // ->visible(fn () => auth()->user()->hasRole('superadmin')),
                //     // logic awal nomor urut
                // Forms\Components\TextInput::make('nomor_urut')
                //     ->label('Nomor Urut')
                //     ->default(function () {
                //         $last = \App\Models\SuratKeluar::orderBy('nomor_urut', 'desc')->first();
                //         return $last ? $last->nomor_urut + 1 : 1;
                //     })
                //     ->disabled(),

               // Ganti Select disposisi dengan Select bidang_id
             Forms\Components\Radio::make('bidang_id') // <--- Gunakan 'bidang_id'
                ->label('Bidang') // Label yang lebih sesuai
                ->options($bidangOptions) // <--- Gunakan opsi yang sudah diambil dari DB
                // ->relationship(
                //     'bidang',
                //     'nama_bidang',
                //     function (Builder $query) {
                //         return $query->orderBy('id'); // Urutkan berdasarkan ID
                //     }
                // )
                // Hapus searchable() dan preload() karena tidak relevan untuk Radio
                // ->searchable()
                // ->preload()
                ->required()   // Wajib diisi
                ->inline(),

                Forms\Components\Select::make('klasifikasi_surat_id')
                    ->label('Tugas Klasifikasi')
                    ->relationship('klasifikasi', 'nama')
                    ->searchable()
                    ->reactive()
                    ->required(fn () => Auth::user()->hasRole('superadmin'))
                    ->visible(fn () => Auth::user()->hasRole('superadmin')),
                    // ->required(),

                Forms\Components\Placeholder::make('kode_klasifikasi')
                        ->label('Kode Klasifikasi')
                        ->content(function ($get) {
                            $klasifikasi = KlasifikasiSurat::find($get('klasifikasi_surat_id'));
                            return $klasifikasi?->kode ?? '-';
                        }),

                Forms\Components\TextInput::make('sifat')
                    ->required(),

                Forms\Components\TextInput::make('perihal')
                    ->required(),

                Forms\Components\TextInput::make('kepada')
                    ->required(),

                Forms\Components\DatePicker::make('tanggal_surat')
                ->label('Tanggal Surat')
                ->required(),

                Forms\Components\Textarea::make('keterangan'),

                Forms\Components\FileUpload::make('lampiran')
                    ->label('Lampiran')
                    ->disk('public')
                    ->directory('surat-keluar')
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(2048),

                Forms\Components\RichEditor::make('isi_surat')
                    ->label('Isi Surat')
                    ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'bulletList', 'orderedList', 'link', 'redo', 'undo'
                        ])
                    ->columnSpanFull()
                    ->nullable(),
                ]);
                
            }

            public static function table(Table $table): Table
            {
                return $table
                    ->columns([
                        Tables\Columns\TextColumn::make('nomor_surat')
                        ->label('Nomor Surat')
                        ->sortable()
                        ->searchable()
                        ->disabled(),
                        // ->visible(auth()->user()->hasRole('superadmin')),
                        Tables\Columns\TextColumn::make('nomor_urut')->label('Nomor Urut'),
                        Tables\Columns\TextColumn::make('klasifikasi.kode')->label('Kode'),
                        Tables\Columns\TextColumn::make('sifat'),
                        Tables\Columns\TextColumn::make('perihal'),
                        Tables\Columns\TextColumn::make('kepada'),
                        Tables\Columns\TextColumn::make('disposisi')
                        ->label('Bidang')
                        ->sortable()
                        ->searchable(),
                        Tables\Columns\TextColumn::make('tanggal_surat')
                        ->label('Tanggal Surat')
                        ->date()
                        ->sortable(),
                        Tables\Columns\TextColumn::make('keterangan')->limit(40),
                        Tables\Columns\BadgeColumn::make('status_persetujuan')
                        ->colors([
                            'primary' => 'draft',
                            'warning' => 'menunggu_kabid',
                            'success' => 'disetujui_kabid',
                            'green' => 'disetujui_superadmin',
                        ])
                        ->label('Status')
                        ->sortable(),
                        Tables\Columns\BadgeColumn::make('kadis_ttd_status')
                        ->colors([
                            'gray' => 'belum_ditandatangani',
                            'success' => 'elektronik',
                            'info' => 'manual',
                        ])
                        ->label('Status TTD Kadis')
                        ->sortable()
                        ->visible(fn () => auth()->user()->hasRole('superadmin')), // Hanya terlihat oleh superadmin
                    ])
                    ->actions([
                        Action::make('LihatSuratModal') // Beri nama unik yang tidak ambigu
                        ->label('Lihat Surat')
                        ->modalContent(function ($record): \Illuminate\View\View // Opsional: definisikan return type
                        {
                            // Pastikan route yang dipanggil mengembalikan PDF, seperti yang sudah kita perbaiki di KabidController
                            // Gunakan $record->id untuk parameter route agar lebih eksplisit
                            $pdfUrl = route('preview.surat-keluar', $record->id);

                            // Pastikan 'pdfUrl' adalah kunci array yang sama dengan variabel di Blade
                            return view('filament.resources.surat-keluar-resource.pages.surat-keluar-pdf-modal', [
                                'pdfUrl' => $pdfUrl,
                            ]);
                        })
                        ->modalSubmitAction(false) // Tombol submit tidak diperlukan untuk preview
                        ->modalCancelAction(false) // Tombol cancel tidak diperlukan
                        ->modalWidth('7xl') // Atur lebar modal
                        ->slideOver()// Efek modal slide dari samping
                        ->icon('heroicon-o-eye'), // Gunakan ikon mata untuk melihat surat

                        Tables\Actions\EditAction::make()
                            ->visible(auth()->user()->hasRole('superadmin')),
                        Tables\Actions\DeleteAction::make(),

                        Tables\Actions\Action::make('unduhPdf')
                        ->label('Unduh PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('success')
                        ->action(function ($record) {
                            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('filament.pdf.surat-keluar', [
                                'surat' => $record,
                            ]);
                            
                            return response()->streamDownload(
                                fn () => print($pdf->output()),
                                'surat-keluar-' . $record->nomor_urut . '.pdf'
                            );
                        })
                        ->requiresConfirmation(),
                    ])
                    ->bulkActions([
                        Tables\Actions\DeleteBulkAction::make(),
                    ]);
            }

            function generateNomorSurat($klasifikasiKode)
            {
                $bulan = Carbon::now()->format('m');
                $tahun = Carbon::now()->format('Y');

                $count = SuratKeluar::where('kode_klasifikasi', $klasifikasiKode)
                    ->where('status', 'disetujui')
                    ->whereMonth('created_at', $bulan)
                    ->whereYear('created_at', $tahun)
                    ->count();

                $urut = str_pad($count + 1, 3, '0', STR_PAD_LEFT);

                return "{$urut}/{$klasifikasiKode}/{$bulan}/{$tahun}";
            }

            public static function getEloquentQuery(): Builder
            {
                if (auth()->user()->hasRole('superadmin')) {
                    // Superadmin melihat surat yang statusnya 'disetujui_kabid' (menunggu mereka)
                    // DAN 'disetujui_superadmin' (sudah mereka proses/selesai)
                    return parent::getEloquentQuery()->whereIn('status_persetujuan', ['disetujui_kabid', 'disetujui_superadmin']);
                }

                // Untuk peran lain yang mungkin mengakses resource ini (jika ada),
                // atau sebagai fallback jika tidak ada filter role yang cocok.
                // Anda bisa tambahkan filter lain di sini jika diperlukan,
                // misalnya agar admin tidak bisa melihat resource ini sama sekali.
                return parent::getEloquentQuery();
            

                // if (auth()->user()->hasRole('superadmin')) {
                //     return parent::getEloquentQuery()->where('status_persetujuan', 'disetujui_kabid');
                // }

                // return parent::getEloquentQuery();
            }

            public static function canAccess(): bool
            {
                return Auth::user()->hasAnyRole(['superadmin', 'admin']);
            }

            

            public static function getRelations(): array
            {
                return [
                    //
                ];
            }

            public static function getPages(): array
            {
                return [
                    'index' => Pages\ListSuratKeluars::route('/'),
                    'create' => Pages\CreateSuratKeluar::route('/create'),
                    'edit' => Pages\EditSuratKeluar::route('/{record}/edit'),
                ];
            }

    // app/Filament/Resources/SuratKeluarResource/Pages/EditSuratKeluar.php

// protected function beforeSave(): void
// {
//     $data = $this->form->getState();
//     $klasifikasi = \App\Models\KlasifikasiSurat::find($data['klasifikasi_surat_id']);

//     if (
//         $klasifikasi &&
//         $klasifikasi->kode !== '000' &&
//         ($this->record->nomor_surat === 'PENDING' || $this->record->nomor_urut === 0)
//     ) {
//         $lastNomorUrut = \App\Models\SuratKeluar::max('nomor_urut') ?? 0;
//         $this->record->nomor_urut = $lastNomorUrut + 1;
//         $tahun = now()->year;
//         $kodeKlasifikasi = $klasifikasi->kode;
//         $this->record->nomor_surat = "{$kodeKlasifikasi}/{$this->record->nomor_urut}/{$tahun}";
//     }
// }


//     public static function mutateFormDataBeforeSave(array $data): array
// {
//     $klasifikasi = \App\Models\KlasifikasiSurat::find($data['klasifikasi_surat_id']);

//     if (
//         $klasifikasi &&
//         $klasifikasi->kode !== '000' &&
//         ($data['nomor_surat'] === 'PENDING' || $data['nomor_urut'] === 0)
//     ) {
//         // Ambil nomor urut terakhir
//         $lastNomorUrut = \App\Models\SuratKeluar::max('nomor_urut') ?? 0;
//         $data['nomor_urut'] = $lastNomorUrut + 1;

//         // Contoh format nomor_surat: KLS.005/001/2025
//         $tahun = now()->year;
//         $kodeKlasifikasi = $klasifikasi->kode;
//         $data['nomor_surat'] = "{$kodeKlasifikasi}/{$data['nomor_urut']}/{$tahun}";
//     }

//     return $data;
// }


}
