<?php

return [

    /*
    * set the client id
    */
    'clientId' => env('EC8964DE99C7414A8E0F05FFA33C5AF2'),

    /*
    * set the client secret
    */
    'clientSecret' => env('KqEEe_vS13qSsT1A3QTRwsq871zrY0ozU-aqV8khWvW-50_p'),

    /*
    * Set the url to trigger the oauth process
    */
    'redirectUri' => env('XERO_REDIRECT_URL'),

    /*
    * Set the url to redirecto once authenticated;
    */
    'landingUri' => env('XERO_LANDING_URL', '/'),

    /**
     * Set access token, when set will bypass the oauth2 process
     */
    'accessToken' => env('eyJhbGciOiJSUzI1NiIsImtpZCI6IjFDQUY4RTY2NzcyRDZEQzAyOEQ2NzI2RkQwMjYxNTgxNTcwRUZDMTkiLCJ0eXAiOiJKV1QiLCJ4NXQiOiJISy1PWm5jdGJjQW8xbkp2MENZVmdWY09fQmsifQ.eyJuYmYiOjE2NzE3OTQ5NjYsImV4cCI6MTY3MTc5Njc2NiwiaXNzIjoiaHR0cHM6Ly9pZGVudGl0eS54ZXJvLmNvbSIsImF1ZCI6Imh0dHBzOi8vaWRlbnRpdHkueGVyby5jb20vcmVzb3VyY2VzIiwiY2xpZW50X2lkIjoiRUM4OTY0REU5OUM3NDE0QThFMEYwNUZGQTMzQzVBRjIiLCJzdWIiOiI2NGU5M2M4OTc1N2I1MjdiOTBlYTYxMDAxNTcwMGY3YSIsImF1dGhfdGltZSI6MTY3MTc5NDk1MSwieGVyb191c2VyaWQiOiIwZjk1MjdlMS1lNmIwLTQ4YjMtODBkOC0zMGJjZmQyNjFkNDUiLCJnbG9iYWxfc2Vzc2lvbl9pZCI6ImVkOTIwYTlmZjBkNzQzZjVhMjU1MzMxZWM0NTE4NmNmIiwianRpIjoiQ0MzREJCMTMzQjg5Qjg3OTcxMjdFREE1RjY1NUI3QzAiLCJhdXRoZW50aWNhdGlvbl9ldmVudF9pZCI6IjEyODlhZTY4LTJjYTQtNDE2Ni05ZmYxLWYzY2U1ZjZkZWQ4OSIsInNjb3BlIjpbImVtYWlsIiwicHJvZmlsZSIsIm9wZW5pZCIsImFjY291bnRpbmcuc2V0dGluZ3MiLCJhY2NvdW50aW5nLmNvbnRhY3RzIl0sImFtciI6WyJwd2QiLCJtZmEiLCJzd2siXX0.VojoGtkOsE2R71BW1Q4CVtwE1PKhEQir3qr0AErYcmAAzkjRHTnsmqCxL_B651VPagE0_ULigCNgVfZ10WFs-J0EZ0z-Bb6qOSjYhK0msYs4OaWkynUV2FU0E1othvGvnZGqmW-6YDcPKtDqyU_A14cKQppmrc-ru3BUcKHslNG3hRk0xVeDJi_4BRDWh96DMvFbbU-C20sKKCRg0TYxANkqTv9lOhnwm57FzCCXwVb1msvMs8ogwiEReiMVqAmXIqnPbkoydPfETINPAwhtq2d_sWBwsJlJZnemYVRBRcNqRtvlKpX4mKJhDqHGL04gjqjuHBdzTPG4L2eOqjvwjg', ''),

    /**
     * Set webhook token
     */
    'webhookKey' => env('XERO_WEBHOOK_KEY', ''),

    /**
     * Set the scopes
     */
    'scopes' => env('XERO_SCOPES', 'openid email profile offline_access accounting.settings accounting.transactions accounting.contacts'),
];