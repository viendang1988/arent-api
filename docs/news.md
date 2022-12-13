###1.  CREATE NEWS API
```json
POST /api/news HTTP/1.1
Host: localhost:8001
Authorization: Bearer {{token}}
Content-Type: application/json

{
    "title": "News 1",
    "content": "News 1",
    "category": "/api/news-categories/1"
}
```

###2.  GET NEWS API (WITHOUT LOGIN)
```json
GET /api/news HTTP/1.1
Host: localhost:8001
```

Response
```json
{
    "links": {
        "self": "/api/news"
    },
    "meta": {
        "totalItems": 2,
        "itemsPerPage": 30,
        "currentPage": 1
    },
    "data": [
        {
            "id": "/api/news/1",
            "type": "news",
            "attributes": {
                "title": "test ABC",
                "content": "test ABC"
            },
            "relationships": {
                "category": {
                    "data": {
                        "type": "news-category",
                        "id": "/api/news-categories/1"
                    }
                }
            }
        },
        {
            "id": "/api/news/2",
            "type": "news",
            "attributes": {
                "title": "test ABC",
                "content": "test ABC",
                "createdAt": "2022-12-13T23:05:31+07:00",
                "updatedAt": "2022-12-13T23:05:31+07:00"
            },
            "relationships": {
                "category": {
                    "data": {
                        "type": "news-category",
                        "id": "/api/news-categories/1"
                    }
                }
            }
        }
    ]
}
```


###3. GET NEWS DETAIL (WITHOUT LOGIN)
```json
GET /api/news/1 HTTP/1.1
Host: localhost:8001
```

Response:
```json
{
    "data": {
        "id": "/api/news/1",
        "type": "news",
        "attributes": {
            "title": "test ABC",
            "content": "test ABC"
        },
        "relationships": {
            "category": {
                "data": {
                    "type": "news-category",
                    "id": "/api/news-categories/1"
                }
            }
        }
    }
}
```
