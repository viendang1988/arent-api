###1. CREATE NEW EXERCISE (NEED LOGIN)
```json
POST /api/exercises HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
Content-Type: application/json
Content-Length: 65

{
    "name": "Exercises 1",
    "rate": 100,
    "type": 2
}
```

`rate`: number calories burnt in 1 minute

`type`
```json
TYPE_SYSTEM = 1; //system suggest for user
TYPE_CUSTOM_FOR_USER = 2; //user add manually
```
###2. GET EXERCISES (NEED LOGIN)
```json
GET /api/exercises HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
```

Response:
```json
{
    "links": {
        "self": "/api/exercises"
    },
    "meta": {
        "totalItems": 4,
        "itemsPerPage": 30,
        "currentPage": 1
    },
    "data": [
        {
            "id": "/api/exercises/1",
            "type": "exercise",
            "attributes": {
                "name": "Exercises 1",
                "rate": 100,
                "_type": 1
            }
        },
        {
            "id": "/api/exercises/2",
            "type": "exercise",
            "attributes": {
                "name": "Exercises 1",
                "rate": 100,
                "_type": 2
            }
        },
        {
            "id": "/api/exercises/3",
            "type": "exercise",
            "attributes": {
                "name": "Exercises 1",
                "rate": 100,
                "_type": 2
            },
            "relationships": {
                "createdBy": {
                    "data": {
                        "type": "user",
                        "id": "/api/users/1"
                    }
                }
            }
        },
        {
            "id": "/api/exercises/4",
            "type": "exercise",
            "attributes": {
                "name": "Exercises 1",
                "rate": 100,
                "_type": 2,
                "createdAt": "2022-12-13T23:40:46+07:00",
                "updatedAt": "2022-12-13T23:40:46+07:00"
            },
            "relationships": {
                "createdBy": {
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
