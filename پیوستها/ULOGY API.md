## ULOGY API

baseURL: <https://api.tabibestan.com>

__Roles__
* `U` => User
* `D` => Doctor
* `S` => Support
* `A` => Admin‌

__No Auth API__
 Method | Roles | Path                           | Data / Query
--------|-------|--------------------------------|------------------------------
GET     | -     | `/view/teachers/list`          | `?sort=<Sort Field : "date:dsc">&filter[<field>]=<Filter Value : "">&n=<Items Per Page : "20">&p=<Page Number : "1">`
GET     | -     | `/view/comment`                | { fullname, mobile, email, text }
GET     | -     | `/view/teachers/:id`           |
GET     | -     | `/view/teachers/:id`           | `?knd_class=<1,2,3>`
--------------------------------------------------------------------------------
POST    | -     | `/account/duplicate`           | { username }
POST    | -     | `/account/recovery`            | { mobile }
POST    | -     | `/account/signup`              | { fullname, mobile, email, password, username }
POST    | -     | `/account/login`               | { username, password }
--------------------------------------------------------------------------------
POST    | -     | `/teachers/reserved`           | { classes_id, knd_class, username, teacher, date_class, time_class, degre, category, field, explain, address, }
POST    | -     | `/teachers/proposal`           | { degre, category, field, explain, address }
--------------------------------------------------------------------------------
POST    | -     | `/reserved/setStatus`          | {status, id}
GET     | -     | `/reserved/:id`                |
POST    | -     | `/reserved/:id`                | {username}
POST    | -     | `/reserved/link/:id`           | {role, link}
POST    | -     | `/reserved/teachers`           | {username, role}
--------------------------------------------------------------------------------
POST    | -     | `/user/address`                | {username, address}
--------------------------------------------------------------------------------
GET     | -     | `/category/list`               | `?sort=<Sort Field : "date:dsc">&search=<Filter Value : "">&n=<Items Per Page : "20">&p=<Page Number : "1">`
GET     | -     | `/category/:id`                |
--------------------------------------------------------------------------------
GET     | -     | `/knd_class/list`              | `?sort=<Sort Field : "date:dsc">&filter[<field>]=<Filter Value : "">&n=<Items Per Page : "20">&p=<Page Number : "1">`
--------------------------------------------------------------------------------
GET     | -     | `/field/list`                  | `?sort=<Sort Field : "date:dsc">&filter[<field>]=<Filter Value : "">&n=<Items Per Page : "20">&p=<Page Number : "1">`
--------------------------------------------------------------------------------
GET     | -     | `/sex/list`                    | `?sort=<Sort Field : "date:dsc">&filter[<field>]=<Filter Value : "">&n=<Items Per Page : "20">&p=<Page Number : "1">`
--------------------------------------------------------------------------------
GET     | -     | `/degrees/list`                | `?sort=<Sort Field : "date:dsc">&filter[<field>]=<Filter Value : "">&n=<Items Per Page : "20">&p=<Page Number : "1">`
--------------------------------------------------------------------------------
GET     | -     | `/location/highlights`         |
GET     | -     | `/location`                    |
--------------------------------------------------------------------------------
GET     | -     | `/chat/:id`                    |
POST    | -     | `/chat/:id`                    | {chat}
POST    | -     | `/chat/admin`                  | {username}
--------------------------------------------------------------------------------
POST    | -     | `/support/list`                | {role}
POST    | -     | `/support/read`                | {role, id}
--------------------------------------------------------------------------------
POST    | U     | `/self/account`                | { fullname, province, county, degrees, field, email, username }
POST    | U     | `/self/account/setpass`        | { cur, password }
POST    | -     | `/accountTeacher/signup`       | { fullname, phone, province, county, sex, degrees, field, category, public_phone, address, about_me, email, username, password }
--------------------------------------------------------------------------------
POST    | -     | `/classes/list`                | { role, teacher }
POST    | -     | `/classes/create`              | { role, teacher }
--------------------------------------------------------------------------------
POST    | -     | `/all/public`                 | { }
