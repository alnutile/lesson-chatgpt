# Example Ideas using ChatGPT

The OpenAPI can be used in so many ways from product to helping us create logic from 
simple sentences here are some examples

## Setup

Normal Laravel install

```bash 
cp .env.example .env
```
Edit the .env to add your username and password

```dotenv
ADMIN_USERNAME=alfrednutile@gmail.com
ADMIN_PASS=foobar
```

Then
```bash
composer install
touch database/database.sqlite
php artisan migrate --seed
npm install
npm run dev
```

We will be using this library [https://github.com/openai-php/laravel](https://github.com/openai-php/laravel) to wrap around
[https://github.com/openai-php/client](https://github.com/openai-php/client)

## Barber Shop Email or Chat
See video here 

```text
A customer wants a haircut sunday March 18th, between 2pm and 4pm, we have four barbers on that day. Bob who works 9am to 4pm, sam who works 9am to 2pm, Jen who works 9am to 3pm, Steve who works 9am to 7pm. People who have days off are Jen March 18th. Lunch breaks are as follows, Bob 12pm to 1pm, Sam 1pm to 2pm, Steve 11am to 12pm Haircuts take 30 minutes can you suggest two possible timeslots for the customer.
```

## Tagging

## Story and Images

## Schedule Planner for Freelancer

## Image Helper 

## Recipe generation 

## 
