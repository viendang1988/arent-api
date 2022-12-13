###1.  CREATE USER API (WITHOUT JWT_TOKEN)
```json
POST /api/users HTTP/1.1
Host: localhost:8001
Content-Type: application/json
Content-Length: 258

{
    "firstName": "vien",
    "lastName": "Dang",
    "email": "vien.dang@nfq.asia",
    "birthday": "2022-12-13",
    "currentWeight": 58,
    "currentGoal": 1,
    "goalWeight": 60,
    "height": 165,
    "gender": 1,
    "password": "123123"
}
```

###2.  USER LOGIN API
```json
POST /api/login_check HTTP/1.1
Host: localhost:8001
Content-Type: application/json
Content-Length: 66

{
    "email": "vien.dang@nfq.asia",
    "password": "123123"
}
```

If login successfull, we will receive the response witt jwt-token
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE2NzA5NDc0NzAsImV4cCI6MTY3MDk1MTA3MCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sImVtYWlsIjoidmllbi5kYW5nQG5mcS5hc2lhIn0.WCxzncJ5F3gLpk7Rkd0hByDUFLGfcypFkYtm8azDpeQAs725odT07gYamq0ZZZ9_TlGOQgw8xMZL2mqTiP7ivDl7nJGCnqCh10lLtO2phgTXRb-7G0kwmceLYr-CUrIkD3D5cSSb65KxRXmFc-5qrJMFp5bJNETr2VmRT48KRrv_rrmb8X0igUzaXU_E9DSZhX3d2xZcW5zyxAvsYmaLUBmDUMpARCRYl2Cd8UjDbOLRenlVzXQdLbVtnniTTZV0rwZl0nd2WolZ6_lEHO8hqEQNLIN9j7eTvQOJjBIzvvcvBFP8XIiUCmTcyE4dclvyJU5fGKsuGq9XFiwX58L2uA"
}
```
