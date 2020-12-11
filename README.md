# game-company-git
 ### 1. Prepare database.
 
 #### 1.1 Install database MariaDB https://mariadb.com/downloads/
 
 If DB is installed on a different VM/Server/PC (not the one "hosting" Web-service) - modify function **get_introdb_conn()** in file **./common/functions_defs.php**
 
 ```
function get_introdb_conn() {
    return new mysqli("<INSERT_REMOTE_IP_FQDN_HERE>", "intro", "intro", "introdb");
}
 ```
 
 #### 1.2 Create user **intro/intro** and database **introdb**:
 
 ```
 create user intro identified by 'intro';
 create database introdb character set = 'UTF8';
 grant usage on *.* to 'intro'@localhost identified by 'intro';
 GRANT ALL privileges ON `introdb`.* TO 'intro'@localhost;
```
 
 #### 1.3 Create table **users** and add user **admin/admin**:
 
 ```
 create table users
 (
     username varchar(50) primary key,
     password varchar(255) not null,
     email varchar(50)
 );
 
 insert into users(username, password, email)
 values ('admin','$2y$12$V1pbm1dUZlfUkkl2mmRIXuQrfYx31J77Gu2N1uKoUiuI0hPIyJ8Da','admin@gmail.com'),
 ```

 #### 1.4 Create table **vr_games** and add few games:
 
 ```
 create table vr_games
 (
     id int primary key auto_increment,
     image varchar(200),
     gamename varchar(50) not null,
     subtitle varchar(150),
     description varchar(430),
     price decimal(5, 2) not null
 );
 
 insert into vr_games(image, gamename, subtitle, description, price)
 values ('./img/chiaro-300x300.png', 'Chiaro', 'THE FIRST-PERSON VR ADVENTURE GAME WHICH WON AN NVIDIA EDGE PROGRAM PRIZE FOR EXCELLENCE IN AESTHETIC ACHIEVEMENT.','Chiaro and the Elixir of Life is a first-person virtual reality adventure game. Step into the role of Chiaro (voiced by Taylor Gray, Star Wars Rebels), a young engineer returning home to the forest of Neverain to build a machine called Boka and bring him to life with Elixir, a powerful ancient fuel. Together Boka and Chiaro form an unbreakable bond and embark on an epic adventure to find the lost Fountain of Elixir','39.99'),
        ('./img/forged-300x300.png', 'Forged', 'FORGED IS A FIRST-PERSON VIRTUAL REALITY ADVENTURE GAME', 'The wonderful story about a strong woman, Qadira, who fights with evil creatures from Dekar. She has devoted her life to fight back the Blossom of Omara, a sinister influence pouring from a rift between worlds that corrupts everything it touches.','59.99');
 ```

#### 2. Install Web-server

Install Web-server of your choice (Apache/Nginx) and upload provided files to it.
Otherwise you can simply use IDE with embedded Web-server (like PhpStorm or similar).

#### 3. Website administration

Log in using admin/admin to manage website's content.

#### 4. List of implemented features

- all data stored in DB;
- create new user account;
- log in;
- log out;
- add new game (admin only);
- edit game (admin only);
- delete game (admin only);
- social media with links;
- re-usable header, footer and functions.

#### 5. List of future features

- shopping cart (currently static);
- content of **About** page;
- **Subscribe** section;
- change password by user.


