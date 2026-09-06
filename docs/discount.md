# Discount Module

MSRadmin-এর Discount Module ব্যবহার করে store-এর products-এর উপর automatic discount/promotion manage করা হয়। Customer-এর কোনো coupon code দেওয়ার প্রয়োজন হয় না; applicable discount system automatically calculate করে।

## Discount কীভাবে কাজ করে

Discount তিনভাবে apply করা যায়:

- **Global Discount** — কোনো Product বা Category select না করলে পুরো store-এর eligible products-এর উপর discount apply হবে।
- **Product Discount** — নির্দিষ্ট products select করলে শুধু সেই products-এর উপর discount apply হবে।
- **Category Discount** — নির্দিষ্ট product categories select করলে ওই categories-এর products-এর উপর discount apply হবে।

যদি Product এবং Category দুটোই select করা হয়, বর্তমান logic অনুযায়ী Product অথবা Category match করলেই discount applicable হবে।

## Discount Types

Discount দুই ধরনের:

- **Percentage** — যেমন 20% discount
- **Fixed Amount** — যেমন 500 টাকা discount

উদাহরণ:

`Product Price = 2000`

`20% Discount = 400`

`Final Price = 1600`

## Discount Rules

Discount-এর সাথে কিছু rule থাকতে পারে:

- **Minimum Order Amount** — নির্দিষ্ট amount-এর কম order হলে discount apply হবে না।
- **Maximum Discount** — discount-এর সর্বোচ্চ amount নির্ধারণ করে।
- **Starts At** — discount কখন থেকে শুরু হবে।
- **Ends At** — discount কখন শেষ হবে।
- **Priority** — একাধিক discount applicable হলে কোন discount আগে evaluate হবে তা নির্ধারণ করে।
- **Status** — discount Active অথবা Inactive করা যায়।
- **Allow Coupon** — এই discount-এর সাথে coupon ব্যবহার করা যাবে কি না তা নির্ধারণ করে।

## Database Structure

Discount-এর মূল data থাকবে `discounts` table-এ।

Product এবং Category-এর সাথে relationship রাখার জন্য দুটি pivot table থাকবে:

```text
discounts
    |
    +---- discount_products ---- products
    |
    +---- discount_categories -- categories