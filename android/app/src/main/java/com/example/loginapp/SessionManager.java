package com.example.loginapp;

import android.content.Context;
import android.content.SharedPreferences;

/** Guarda la sesión del usuario en SharedPreferences. */
public class SessionManager {
    private static final String PREF = "session";
    private final SharedPreferences prefs;

    public SessionManager(Context context) {
        prefs = context.getSharedPreferences(PREF, Context.MODE_PRIVATE);
    }

    public void saveUser(int id, String name, String email) {
        prefs.edit()
                .putBoolean("logged", true)
                .putInt("id", id)
                .putString("name", name)
                .putString("email", email)
                .apply();
    }

    public boolean isLoggedIn() { return prefs.getBoolean("logged", false); }
    public String getName()     { return prefs.getString("name", ""); }
    public String getEmail()    { return prefs.getString("email", ""); }

    public void logout() { prefs.edit().clear().apply(); }
}
