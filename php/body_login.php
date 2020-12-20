<?php
// выход из пользователя
$LOGIN_COOKIE = "login";
$LOGIN_SECRET_COOKIE = "login_secret";
if (isset($_COOKIE[$LOGIN_COOKIE])) {
    unset($_COOKIE[$LOGIN_COOKIE]);
    setcookie($LOGIN_COOKIE, '', time() - 3600, '/');
}
if (isset($_COOKIE[$LOGIN_SECRET_COOKIE])) {
    unset($_COOKIE[$LOGIN_SECRET_COOKIE]);
    setcookie($LOGIN_SECRET_COOKIE, '', time() - 3600, '/');
}
?>
<body class="bg-primary">
<div id="layoutAuthentication">
    <div id="layoutAuthentication_content">
        <main>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="card shadow-lg border-0 rounded-lg mt-5">
                            <div class="card-header"><h3 class="text-center font-weight-light my-4"><?php
                                    if (!isset($TITLE))
                                        die("Variable \$TITLE should be provided!");
                                    echo $TITLE ?> </h3></div>
