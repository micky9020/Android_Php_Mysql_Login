package com.example.loginapp;

public class Constants {
    // Emulador Android -> 10.0.2.2 apunta al localhost de tu PC.
    // Dispositivo físico -> usa la IP local de tu PC, ej: http://192.168.1.10/login_android/api/
    public static final String BASE_URL = "http://10.0.2.2/login_android/api/";
    public static final String LOGIN_URL = BASE_URL + "login.php";
    public static final String REGISTER_URL = BASE_URL + "register.php";
}
