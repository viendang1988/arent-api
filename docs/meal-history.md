###1. CREATE MEAL HISTORY (NEED LOGIN)
```json
POST /api/meal-histories HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
Content-Type: application/json
Content-Length: 50

{
    "dateSession": 1,
    "image": "image1"
}
```
`image`: path for image

`dateSession`:
```json
DATE_SESSION_MORNING = 1;
DATE_SESSION_LUNCH = 2;
DATE_SESSION_DINNER = 3;
DATE_SESSION_SNACK = 4
```

###2. GET MEAL HISTORY FOR LOGGED USER(NEED LOGIN)
```json
GET /api/meal-histories HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
```

Response
```json
{
    "links": {
        "self": "/api/meal-histories"
    },
    "meta": {
        "totalItems": 1,
        "itemsPerPage": 30,
        "currentPage": 1
    },
    "data": [
        {
            "id": "/api/meal-histories/1",
            "type": "meal-history",
            "attributes": {
                "date": "2022-12-14T00:00:00+07:00",
                "dateSession": 1,
                "image": "image1",
                "createdAt": "2022-12-14T00:01:43+07:00",
                "updatedAt": "2022-12-14T00:01:43+07:00"
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
