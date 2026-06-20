<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KonsepSuratResource\Pages;
use App\Filament\Resources\KonsepSuratResource\RelationManagers;
use App\Models\SuratKeluar;
use App\Models\Bidang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\KlasifikasiSurat;


// controller Konsep Surat untuk admin dan superadmin
class KonsepSuratResource extends Resource
{
    // protected static ?string $model = KonsepSurat::class;

    // protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $model = SuratKeluar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Pengajuan Surat Keluar';

    protected static ?string $modelLabel = 'Surat Keluar';

    protected static ?string $pluralModelLabel = 'Surat Keluar';

    public static function form(Form $form): Form
    {
        $bidangOptions = Bidang::orderBy('id')->pluck('nama_bidang', 'id')->toArray();
        return $form
            ->schema([
    // ==========================> Input form untuk surat keluar - KONSEP SURAT
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

                    Forms\Components\Textarea::make('keterangan'),

                    Forms\Components\FileUpload::make('lampiran')
                        ->label('Lampiran')
                        ->disk('public')
                        ->directory('surat-keluar')
                        ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                        ->maxSize(2048),


                    // ⬇️ Tambahkan ini di posisi yang kamu mau
                    Forms\Components\Select::make('align_style')
                        ->label('Alignment')
                        ->options([
                            'left' => 'Rata Kiri',
                            'center' => 'Tengah',
                            'right' => 'Kanan',
                            'justify' => 'Justify',
                        ])
                        ->default('justify'),

                    Forms\Components\RichEditor::make('isi_surat')
                        ->label('Isi Surat')
                        ->toolbarButtons([
                            'bold', 'italic', 'underline', 'strike',
                            'bulletList', 'orderedList',
                            'alignLeft', 'alignCenter', 'alignRight', 'alignJustify',
                            'link', 'redo', 'undo',
                        ])
                        ->columnSpanFull()
                        ->nullable(),
                    
                    // Hidden field untuk menyimpan bidang_id dari user yang login
                    Forms\Components\Hidden::make('bidang_id')
                        ->default(fn () => auth()->user()->bidang_id) // Otomatis set bidang_id user yang membuat
                        ->required(), // Pastikan bidang_id selalu terisi


    // ==========================> Input form untuk surat keluar - KONSEP SURAT
                ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
    // ==========================> Kolom untuk menampilkan daftar konsep surat
                Tables\Columns\TextColumn::make('sifat'),
                Tables\Columns\TextColumn::make('perihal'),
                Tables\Columns\TextColumn::make('kepada'),
                Tables\Columns\TextColumn::make('disposisi')
                ->label('Bidang')
                ->sortable()
                ->searchable(),
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
    // ==========================> Kolom untuk menampilkan daftar konsep surat
            ])
            ->actions([
    // ==========================> Aksi untuk mengedit, menghapus, dan melihat surat
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

                Tables\Actions\EditAction::make(),
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
    // ==========================> Aksi untuk mengedit, menghapus, dan melihat surat
            
    }

    public static function getEloquentQuery(): Builder
    {
        // Panggil query dasar dari parent resource
        $query = parent::getEloquentQuery();

        // Cek jika pengguna yang sedang login adalah 'admin'
        if (auth()->user()->hasRole('admin')) {
            // Filter surat yang statusnya 'draft' atau 'menunggu_kabid'
            // Status 'disetujui_kabid' dan 'disetujui_superadmin' tidak termasuk di sini
            $query->whereIn('status_persetujuan', ['draft', 'menunggu_kabid']);
        }
        // Jika pengguna adalah 'superadmin' atau peran lain, biarkan semua data terlihat
        // (sesuai dengan default getEloquentQuery atau filter lain yang mungkin ada di SuratKeluarResource)

        return $query;
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
            'index' => Pages\ListKonsepSurats::route('/'),
            'create' => Pages\CreateKonsepSurat::route('/create'),
            'edit' => Pages\EditKonsepSurat::route('/{record}/edit'),
        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['status_persetujuan'] = 'menunggu_kabid';
    return $data;
}


    // public static function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Logika Anda untuk mengisi nilai default
    //     if (!Auth::user()->hasRole('superadmin')) {
    //         $defaultId = \App\Models\KlasifikasiSurat::where('kode', '000')->first()?->id ?? 1;
    //         $data['klasifikasi_surat_id'] = $defaultId; // Contoh: ID klasifikasi default
    //         $data['nomor_urut'] = 0;
    //         $data['nomor_surat'] = 'PENDING';
            
    //     }
    //     return $data;
    // }

//     public static function mutateFormDataBeforeCreate(array $data): array
// {
//     if (!isset($data['klasifikasi_surat_id']) || empty($data['klasifikasi_surat_id'])) {
//         $data['klasifikasi_surat_id'] = \App\Models\KlasifikasiSurat::where('kode', '000')->first()?->id ?? 1;
//     }

//     $data['nomor_urut'] = 0;
//     $data['nomor_surat'] = 'PENDING';

//     return $data;
// }

}
