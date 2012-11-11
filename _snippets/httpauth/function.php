function authenticate($users = array(), $realm = false)
{
  // $users should be an array of user => password.
  if (count($users) == 0) {
    // No users given, add a default.
    $users['admin'] = 'password';
  }

  // If no realm was given, add a default.
  if ($realm === false) {
    $realm = 'Restricted area';
  }

  // If we haven't been passed a username via basic auth, ask for one.
  if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="'.$realm.'"');
    header('HTTP/1.0 401 Unauthorized');
    die('<html><head><title>Unauthorised</title></head><body><h1>Unauthorised</h1><p>You are not authorised to view this page</p></body></html>');
  } elseif (!isset($users[$_SERVER['PHP_AUTH_USER']]) or $users[$_SERVER['PHP_AUTH_USER']] != $_SERVER['PHP_AUTH_PW']) {
    die('<html><head><title>Unauthorised</title></head><body><h1>Unauthorised</h1><p>You are not authorised to view this page</p></body></html>');
  }
}
