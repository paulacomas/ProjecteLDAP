<?php
// LDAP server settings
$ldap_host = 'ldap://192.168.0.1'; // Change this to your LDAP server address
$ldap_port = 389; // Change this to your LDAP server port
$ldap_base_dn = 'dc=projecte,dc=org'; // Change this to your LDAP base DN
$ldap_user_suffix = '@projecte.org'; // Change this to your LDAP user suffix
$ldap_group_dn = 'cn=usuaris,dc=projecte,dc=org'; // Change this to your LDAP group DN if needed

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $username = $_POST['username'];
    $password = $_POST['password'];

    // LDAP connection
    $ldap_conn = ldap_connect($ldap_host, $ldap_port);    
    if ($ldap_conn) {
        // Set LDAP options
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

        // Bind to LDAP server
        $ldap_bind = ldap_bind($ldap_conn, 'cn=' . $username . ',' . $ldap_base_dn, $password);

        if ($ldap_bind) {
            // User authenticated
            // Redirigir a perfil.html
            header("Location: perfil.html");
            exit; // Asegura que el script no continúe después de la redirección
        } else {
            // Authentication failed
            // Permanece en login.html
            header("Location: login.html");
            exit;
        }
    } else {
        // LDAP connection failed
        echo "Failed to connect to LDAP server.";
    }
    // Close LDAP connection
    ldap_close($ldap_conn);
}
?>
