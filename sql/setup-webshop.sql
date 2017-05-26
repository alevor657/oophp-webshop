USE `oophp`;

/*
	README

	Jag gick igenom databasen och märkte att jag redan använder massa index så att 
	jag har inte hittat så många ställen att sätta in några. 
	Jag har kontrollerat ett tal select satser och mina tabeller och jag tycker att
	allting ser tillräckligt bra ut.

*/

-- -----------------------------------------------------
-- Table `oophp`.`category`
-- -----------------------------------------------------
drop table if exists orders;
drop table if exists orderRow;
drop table if exists cart;
drop table if exists neededStuff;
drop table if exists stock;
drop table if exists category;

create table stock (
	`id` int unsigned auto_increment not null,
    `description` varchar(255),
    `img` varchar(255),
    `category` int,
    `price` int not null,
    `quantity` int unsigned,
    
    primary key (`id`)
);

explain stock;

create table category (
	`id` int unsigned auto_increment not null,
    `name` varchar(20),
    
    primary key (`id`)
);

explain category;

create table cart (
	`id` int unsigned auto_increment not null,
    `item_id` int unsigned,
    `item_qty` int unsigned,
    
    primary key (`id`),
    foreign key (`item_id`) references `stock` (`id`)
);

explain cart;

create table orderRow (
	`id` int unsigned auto_increment not null,
    `order_id` int unsigned,
    `item_id` int unsigned,
    `item_qty` int unsigned,
    
	primary key (`id`),
    foreign key (`item_id`) references `stock` (`id`)
);

explain orderRow;

create table orders (
	`id` int unsigned auto_increment not null,
    `order_row_id` int unsigned,
	`order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    primary key (`id`),
    foreign key (`order_row_id`) references `orderRow`(`id`)
);

explain orders;

create table neededStuff (
	`id` int unsigned auto_increment not null,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `name` varchar(255),
    `product_ids` varchar(255),
    
    primary key (`id`)
);

explain neededStuff;

insert into stock values (
	null,
	'Red mug',
	'http://alifesworkmovie.com/blog/wp-content/uploads/2015/05/redmug.jpg',
	2,
	100,
	6
),
(
	null,
	'Glass plate',
	'http://cdnimg3.webstaurantstore.com/images/products/main/106747/126165/the-jay-companies-13-glass-platinum-rim-charger-plate.jpg',
	1,
	200,
	10
),
(
	null,
	'Iron plate',
	'https://4.imimg.com/data4/GX/UH/MY-20681290/cast-iron-plate-250x250.jpg',
	1,
	280,
	5
),
(
	null,
	'Blue mug',
	'https://cdn.pixabay.com/photo/2016/04/13/10/25/cup-1326471_960_720.jpg',
	2,
	160,
	14
),
(
	null,
	'Yellow mug',
	'http://www.neilbrothers.co.uk/images/mugs/durham-yellow.png',
	2,
	90,
	19
);

insert into category(name)
	values ('plate'), ('mug');
    
insert into cart
(
	`item_id`,
	`item_qty`
)
values
	(2, 2),
    (1, 1),
    (3, 1);

DROP VIEW IF EXISTS VgetStock;
create view VgetStock
as
SELECT
	s.id,
	s.description,
	s.img,
    c.name as 'category',
    s.price,
    s.quantity
FROM `stock` as s
	inner join category as c
		on s.category = c.id;
        
select * from VgetStock;
explain select * from VgetStock;

        
DROP VIEW IF EXISTS VgetCart;
create view VgetCart
as
SELECT 
	s.id as 'stockId',
	ca.id,
	s.description,
	s.img,
	c.name as 'category',
	s.price,
	ca.item_qty as 'quantity'
from ((`stock` as s
	inner join category as c
		on s.category = c.id)
	inner join cart as ca
		on ca.item_id = s.id);
        
select * from VgetCart;
explain select * from VgetCart;

--

drop procedure if exists addToCart;

delimiter //
create procedure addToCart(
	addId integer
)
begin
	set @qtyInStock = (select quantity from stock where id = addId);
    set @qtyInCart = (select item_qty from cart where item_id = addId);
    set @currentCartItem = (select item_id from cart where item_id = addId); 
    
	select @qtyInStock, @qtyInCart, @currentCartItem, addId;
            
	if @qtyInStock > @qtyInCart or @qtyInCart is null
    then
		if @currentCartItem is null
        then
			insert into `cart` (item_id, item_qty) values (addId, 1);
		else 
			update cart set item_qty = item_qty + 1 where item_id = addId;
        end if;
	end if;
end

//

delimiter ;

explain select item_qty from cart where item_id = 1;

drop procedure if exists removeFromCart;

delimiter //

create procedure removeFromCart(
	removeId integer
)
	begin
		delete from cart where id = removeId;
	end
//
delimiter ;


drop procedure if exists doOrder;

delimiter //

CREATE PROCEDURE doOrder()
BEGIN
    START TRANSACTION;
		insert into orders values();
		set @currentOrderId = (select max(id) from orders);
    
		insert into orderRow
        (
			order_id,
            item_id,
            item_qty
        )
        select
			@currentOrderId,
            item_id,
            item_qty
		from cart;
        
        update orders
			set order_row_id = @currentOrderId
			where order_row_id is null;
            
		
		update stock
        join cart
			set quantity = (select quantity - item_qty from cart where item_id = stock.id)
            where stock.id = cart.item_id;
		
		-- delete from cart;
    commit;
END

//

delimiter ;

call doOrder();


drop procedure if exists getOrderDetails;

delimiter //

create procedure getOrderDetails(
	orderId integer
)
	begin
		
        select
			o.order_date as 'order_date',
            o.id as 'order_id',
            s.description,
            s.img,
            c.name as 'category',
            s.price,
            ordR.item_qty as 'quantity'
		from orders as o
			inner join stock as s
            inner join category as c
				on s.category = c.id
			inner join orderRow as ordR
				on ordR.item_id = s.id

		where o.id = orderId;
            
	end
//

delimiter ;

call getOrderDetails(1);

drop procedure if exists removeOrder;

delimiter //

create procedure removeOrder(
	orderId integer
)
	begin
		delete from orders where id = orderId;
	end
//

delimiter ;

-- call removeOrder(1);



-- insert into `order` values ();

select * from stock;
select * from category;
select * from cart;
select * from orders;
select * from orderRow;
select * from neededStuff;

drop trigger if exists writeToRefillTable;

delimiter //

create trigger writeToRefillTable
before update 
on stock for each row
	if new.quantity < 5
    then
		insert into neededStuff
		(
			name,
            product_ids
        )
        values
        (
			new.description,
            new.id
        );
	end if;
        
//
    
delimiter ;

drop view if exists VgetNeedeStuff;
create view VgetNeedeStuff
as
	select distinct `date`, `name` from neededStuff;
    
select * from VgetNeedeStuff;