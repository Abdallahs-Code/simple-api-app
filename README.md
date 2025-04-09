step 1 connect to a PostgreSQL database ->
  - make a database in PostgreSQL
  - change this part in the .env file and fill it with your credentials
      DB_DATABASE=database_name
      DB_USERNAME=username
      DB_PASSWORD=password

  - run this command
      php artisan migrate

step 2 start the server ->
  - run this command
      php artisan serve

step 3 setup postman and test ->
  - import the collection.json file
  - create an environment and add these variables
    - localServer and fill it with 127.0.0.1:port
        (you can see the port number when you run the server)
    - token and leave it empty
    - postId and leave it empty
  - select the created environment from the top right of the postman interface
  - test the requests
