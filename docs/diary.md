###1. CREATE NEW DIARY (NEED LOGIN)

```json
POST /api/diaries HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
Content-Type: application/json
Content-Length: 59

{
    "content": "Diary 1 CONTENT",
    "user": "/api/users/1"
}
```


###2. GET DIARIES (NEED LOGIN)
```json
GET /api/diaries HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
```

Response:
```json
{
    "links": {
        "self": "/api/diaries"
    },
    "meta": {
        "totalItems": 4,
        "itemsPerPage": 30,
        "currentPage": 1
    },
    "data": [
        {
            "id": "/api/diaries/1",
            "type": "diary",
            "attributes": {
                "content": "Diary 1",
                "createdAt": "2022-12-13T23:28:39+07:00",
                "updatedAt": "2022-12-13T23:28:39+07:00"
            },
            "relationships": {
                "user": {
                    "data": {
                        "type": "user",
                        "id": "/api/users/1"
                    }
                }
            }
        },
        {
            "id": "/api/diaries/2",
            "type": "diary",
            "attributes": {
                "content": "Diary 1",
                "createdAt": "2022-12-13T23:28:56+07:00",
                "updatedAt": "2022-12-13T23:28:56+07:00"
            },
            "relationships": {
                "user": {
                    "data": {
                        "type": "user",
                        "id": "/api/users/1"
                    }
                }
            }
        },
        {
            "id": "/api/diaries/3",
            "type": "diary",
            "attributes": {
                "content": "Diary 1",
                "createdAt": "2022-12-13T23:29:13+07:00",
                "updatedAt": "2022-12-13T23:29:13+07:00"
            },
            "relationships": {
                "user": {
                    "data": {
                        "type": "user",
                        "id": "/api/users/1"
                    }
                }
            }
        },
        {
            "id": "/api/diaries/4",
            "type": "diary",
            "attributes": {
                "content": "Diary 1",
                "createdAt": "2022-12-14T00:44:12+07:00",
                "updatedAt": "2022-12-14T00:44:12+07:00"
            },
            "relationships": {
                "user": {
                    "data": {
                        "type": "user",
                        "id": "/api/users/1"
                    }
                }
            }
        }
    ]
}
```
