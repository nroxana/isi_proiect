<?php
function LOGGER($user_name, $user_role_id, $log_level, $message)
{
    $handle = fopen('../logs/audit_values.data', 'r');
    $user_levels = fread($handle,filesize('../logs/audit_values.data'));
    fclose($handle);
    
    if( $user_levels[$user_role_id - 1] <= $log_level)
    {
        $my_file = '../logs/logfile.log';
        $handle = fopen($my_file, 'a');
        $data = "[" . date("d-n-Y H:i:s") . "] # " . $user_name . " # : " . $message ."\n";
        fwrite($handle, $data);
        fclose($handle);
    }
}
?>