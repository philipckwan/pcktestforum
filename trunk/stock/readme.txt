1. My database info are located in the include.php, make sure you modify them according to your database

2. Create these 2 tables

create table stock_player_account (
       user_id int not null auto_increment primary key,
       user_name varchar(100),
       cash int default 10000
);

create table stock_portfolio_account (
       user_id int not null references stock_player_account(user_id),
       symbol varchar(10),
       quantity int
);

3. Add a new user by running this mysql query

insert into stock_player_account (user_name) values ("Kenneth");

4. Then you can use "Kenneth" at the login.php page to start

