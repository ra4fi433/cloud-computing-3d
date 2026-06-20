#!/bin/bash

# Function to send a request to the specified URL
command_to_run() {
    # Fetch data from the specified URL
    curl -X GET https://dukcapil3374.e-agendadukcapil.site/telegram/send-message
}

# Run the command once
command_to_run
