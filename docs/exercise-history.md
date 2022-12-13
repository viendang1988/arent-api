###1. CREATE NEW EXERCISE HISTORY (NEED LOGIN)
```json
POST /api/exercise-histories HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
Content-Type: application/json
Content-Length: 58

{
    "exercise": "/api/exercises/4",
    "timer": 30
}
```

Response
```json
{
    "links": {
        "self": "/api/exercise-histories"
    },
    "meta": {
        "totalItems": 1,
        "itemsPerPage": 30,
        "currentPage": 1
    },
    "data": [
        {
            "id": "/api/exercise-histories/1",
            "type": "exercise-history",
            "attributes": {
                "date": "2022-12-13T00:00:00+07:00",
                "timer": 30,
                "caloriesBurnt": 3000,
                "createdAt": "2022-12-13T23:52:55+07:00",
                "updatedAt": "2022-12-13T23:52:55+07:00"
            },
            "relationships": {
                "user": {
                    "data": {
                        "type": "user",
                        "id": "/api/users/1"
                    }
                },
                "exercise": {
                    "data": {
                        "type": "exercise",
                        "id": "/api/exercises/4"
                    }
                }
            }
        }
    ]
}
```

