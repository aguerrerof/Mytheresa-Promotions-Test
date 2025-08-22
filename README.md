# Mytheresa Promotions

### Previous steps to Set Up the Project

1) In the root directory, run the command ``` cp .env.example .env```
2) Set the variables ```DB_CONNECTION=sqlite```  y ``` DB_DATABASE=/var/www/html/database/database.sqlite```

### Local server
Run the command in the root directory ```docker-compose build --no-cache && docker-compose up -d``` and you will reach the app in ```http://127.0.0.1:8000```

### Generate key for laravel
Run the command in the root directory ```docker-compose exec app php artisan key:generate```

### Seeders
To populate the database with test records, in the root directory run the command:

```docker-compose exec app php artisan db:seed```

### Tests
To run the test suite, in the root directory execute the command:

```docker-compose exec app php artisan test```

## Endpoints 

### Get Products by Category

This endpoint retrieves a list of products filtered by the specified category. It is particularly useful for applications that need to display products based on user-selected categories.

### Request

- **Method**: GET
- **URL**: `{BASE_URL}/api/products`


#### Query Parameters

- **category** (string|optional): The category of products to filter by. In this example, the category is set to `boots`.
- **price_less_than** (string|optional): Filter products by their original price, before any discounts are applied.


### Response

Upon a successful request, the server responds with a JSON object containing the following structure:

- **products** (array): An array of product objects that match the specified category. Each product object contains details about the product (not specified in this response).

- **total** (integer): The total number of products available in the specified category.

- **per_page** (integer): The number of products returned per page in the response.

- **current_page** (integer): The current page number of the returned results.

- **last_page** (integer): The total number of pages available for the given category.


#### Example Response

``` json
{
  "products": [],
  "total": 0,
  "per_page": 0,
  "current_page": 0,
  "last_page": 0
}

 ```

### Notes

- If there are no products available in the specified category, the `products` array will be empty, and the `total`, `per_page`, `current_page`, and `last_page` values will reflect that there are no results.

- Ensure that the category parameter is correctly specified to retrieve the desired products.
