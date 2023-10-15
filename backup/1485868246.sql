SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
--Database: `pos`




CREATE TABLE `bugs` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `bug_num` varchar(60) NOT NULL,
  `date` datetime NOT NULL,
  `notes` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_clients` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `balance` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_companies` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `CompaniesName` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `GroupName` (`CompaniesName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_config` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `CompanyName` varchar(255) NOT NULL,
  `isLogo` int(1) NOT NULL,
  `Logo` varchar(255) NOT NULL,
  `TimeZone` varchar(255) NOT NULL,
  `Currency` int(1) NOT NULL,
  `Language` int(1) NOT NULL,
  `E_mail` varchar(255) NOT NULL,
  `Website` varchar(255) NOT NULL,
  `PrintingAftermarket` int(1) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `ReturnPolicy` varchar(255) NOT NULL,
  `Phone` varchar(60) NOT NULL,
  `Branch` int(3) NOT NULL,
  `CustomField1` varchar(255) NOT NULL,
  `CustomField2` varchar(255) NOT NULL,
  `CustomField3` varchar(255) NOT NULL,
  `LastInvoiceNo` int(255) NOT NULL,
  `LastreceivingsInvoiceNo` varchar(255) NOT NULL,
  `LastsaleInvoiceNo` int(255) NOT NULL,
  `cat_items_show` varchar(255) NOT NULL,
  `sales_type` int(1) NOT NULL,
  `receivings_type` int(1) NOT NULL,
  `tax` int(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO cairo_config VALUES
("1","برنامج المحلات","0","","Africa/Cairo","2","1","","","0","","","","0","","","","0","0","0","0","1","0","0");




CREATE TABLE `cairo_customer_payments` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `client` varchar(255) NOT NULL,
  `Amount` varchar(11) NOT NULL,
  `Date` date NOT NULL,
  `PaymentMethod` int(1) NOT NULL,
  `Due_Date` date NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_expenses` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `Amount` decimal(10,3) NOT NULL,
  `Employee` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `details` longtext NOT NULL,
  `user` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_expenses_set` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `expensestype` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `GroupName` (`expensestype`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;


INSERT INTO cairo_expenses_set VALUES
("3","ايجار"),
("1","عمولة بيع"),
("2","كهرباء");




CREATE TABLE `cairo_fawry` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `Amount` varchar(255) NOT NULL,
  `Employee` varchar(255) NOT NULL,
  `method` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `due_date` date NOT NULL,
  `details` longtext NOT NULL,
  `user` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_groups` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `GroupName` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `useimage` int(1) NOT NULL,
  `background` varchar(7) NOT NULL,
  `rank` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `GroupName` (`GroupName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_items_hide` (
  `item` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;






CREATE TABLE `cairo_payments_suppliers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `Supplier` varchar(255) NOT NULL,
  `Amount` varchar(11) NOT NULL,
  `Date` date NOT NULL,
  `PaymentMethod` int(1) NOT NULL,
  `Due_Date` date NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_receivings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `unit` int(1) NOT NULL,
  `Discount` varchar(3) NOT NULL DEFAULT '0',
  `Total` varchar(11) NOT NULL,
  `SupplierID` varchar(255) NOT NULL,
  `BuyPrice` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `subqty` varchar(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_receivings_inv` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `Total` varchar(11) NOT NULL,
  `supplier` varchar(60) NOT NULL,
  `PaymentMethod` int(1) NOT NULL,
  `paid` varchar(11) NOT NULL,
  `DueDate` date NOT NULL,
  `CheckNumber` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `type` varchar(20) NOT NULL,
  `discount` varchar(5) NOT NULL,
  `doc` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_receivings_suspended` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `unit` int(1) NOT NULL,
  `Discount` varchar(3) NOT NULL DEFAULT '0',
  `Total` varchar(11) NOT NULL,
  `SupplierID` varchar(255) NOT NULL,
  `BuyPrice` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `subqty` varchar(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_receivings_temporary` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `unit` int(1) NOT NULL,
  `Discount` varchar(3) NOT NULL DEFAULT '0',
  `Total` varchar(11) NOT NULL,
  `SupplierID` varchar(255) NOT NULL,
  `BuyPrice` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `subqty` varchar(5) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_sales` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `Discount` varchar(3) NOT NULL DEFAULT '0',
  `Total` varchar(11) NOT NULL,
  `SupplierID` varchar(255) NOT NULL,
  `BuyPrice` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `subqty` varchar(10) NOT NULL,
  `sales_type` varchar(1) NOT NULL,
  `user_id` int(11) NOT NULL,
  `staff` int(10) NOT NULL,
  `tax` decimal(10,3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_sales_cart` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `Discount` varchar(3) NOT NULL,
  `Total` varchar(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_sales_inv` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `discount` varchar(5) NOT NULL,
  `Total` varchar(11) NOT NULL,
  `supplier` varchar(60) NOT NULL,
  `PaymentMethod` int(1) NOT NULL,
  `paid` varchar(11) NOT NULL,
  `DueDate` date NOT NULL,
  `CheckNumber` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `type` int(1) NOT NULL,
  `sales_type` int(1) NOT NULL,
  `staff` int(10) NOT NULL,
  `doc` int(10) NOT NULL,
  `tax` decimal(10,3) NOT NULL,
  `shipping` decimal(10,2) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_sales_suspended` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `Discount` varchar(3) NOT NULL DEFAULT '0',
  `Total` varchar(11) NOT NULL,
  `SupplierID` varchar(255) NOT NULL,
  `BuyPrice` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `subqty` varchar(10) NOT NULL,
  `sales_type` varchar(1) NOT NULL,
  `staff` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_sales_temporary` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `Price` varchar(11) NOT NULL,
  `Quantity` varchar(11) NOT NULL,
  `color` varchar(10) NOT NULL,
  `size` varchar(10) NOT NULL,
  `Discount` varchar(3) NOT NULL DEFAULT '0',
  `Total` varchar(11) NOT NULL,
  `SupplierID` varchar(255) NOT NULL,
  `BuyPrice` varchar(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL,
  `subqty` varchar(10) NOT NULL,
  `sales_type` varchar(1) NOT NULL,
  `staff` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=92 DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_settings` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO cairo_settings VALUES
("1","1");




CREATE TABLE `cairo_staff` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `commission` int(3) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `balance` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `staff` int(10) NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_suppliers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `notes` longtext NOT NULL,
  `balance` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `state` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_treasury` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `type` varchar(1) NOT NULL,
  `date` datetime NOT NULL,
  `Amount` varchar(11) NOT NULL,
  `notes` longtext NOT NULL,
  `inv_id` int(11) NOT NULL,
  `inv_type` int(11) NOT NULL,
  `client_supp_name` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `cairo_users` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `sale` varchar(1) NOT NULL,
  `buy` varchar(1) NOT NULL,
  `SoldReturns` varchar(1) NOT NULL,
  `purchasesReturns` varchar(1) NOT NULL,
  `DeleteBllsOfSale` varchar(1) NOT NULL,
  `DeletePurchaseInvoices` varchar(1) NOT NULL,
  `ModifyBillsOfSale` varchar(1) NOT NULL,
  `ModifyBillsBuy` varchar(1) NOT NULL,
  `Revenue` varchar(1) NOT NULL,
  `Expenses` varchar(1) NOT NULL,
  `Customers` varchar(1) NOT NULL,
  `Suppliers` varchar(1) NOT NULL,
  `GeneralSettings` varchar(1) NOT NULL,
  `Groups` varchar(1) NOT NULL,
  `Items` varchar(1) NOT NULL,
  `UsersAndPermissions` varchar(1) NOT NULL,
  `ReportsPurchases` varchar(1) NOT NULL,
  `SalesReports` varchar(1) NOT NULL,
  `ReportsSuppliers` varchar(1) NOT NULL,
  `CustomerReports` varchar(1) NOT NULL,
  `InventoryReports` varchar(1) NOT NULL,
  `ReportsRevenues` varchar(1) NOT NULL,
  `ExpenseReports` varchar(1) NOT NULL,
  `ReportsOfPayments` varchar(1) NOT NULL,
  `EditPrice` varchar(1) NOT NULL,
  `profit` varchar(1) NOT NULL,
  `employee` varchar(1) NOT NULL,
  `user_treasury` int(1) NOT NULL,
  `tax` int(2) NOT NULL,
  `IsAdmin` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


INSERT INTO cairo_users VALUES
("1","demo","demo","demo","1","1","1","1","","","","","1","1","1","1","1","1","1","1","1","1","1","1","1","","1","","","1","1","1","0","1");




CREATE TABLE `clients` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `responsible` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `balance` decimal(10,3) NOT NULL,
  `details` char(255) NOT NULL,
  `pos` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `color` varchar(60) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `items` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `groupid` int(11) NOT NULL,
  `item` varchar(70) NOT NULL,
  `date` date NOT NULL,
  `Quantity` int(11) NOT NULL DEFAULT '0',
  `Retail_price` varchar(11) NOT NULL,
  `price` varchar(11) NOT NULL,
  `Sale_wholesale_price` varchar(11) NOT NULL,
  `Barcode` varchar(255) NOT NULL,
  `Supplier` varchar(255) NOT NULL,
  `Discount` varchar(3) NOT NULL,
  `useimage` int(1) NOT NULL,
  `image` varchar(255) NOT NULL,
  `Background` varchar(11) NOT NULL,
  `OrderNo` varchar(255) NOT NULL,
  `subqty` varchar(10) NOT NULL,
  `alert_shortcomings` varbinary(6) NOT NULL,
  `subprice` varbinary(6) NOT NULL,
  `companies` int(60) NOT NULL,
  `sizes` varchar(255) NOT NULL,
  `colors` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item` (`item`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `items_inv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inv_id` varchar(11) NOT NULL,
  `Item` varchar(11) NOT NULL,
  `quantity` varchar(20) NOT NULL,
  `discount` decimal(10,3) NOT NULL,
  `unit_price` decimal(20,2) NOT NULL,
  `color` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `models` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `models_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `barcode` varchar(255) NOT NULL,
  `sizes` varchar(255) NOT NULL,
  `colors` varchar(255) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `on_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employees_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `amount` varchar(6) NOT NULL,
  `notes` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `owners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `percentage` int(3) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `products` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(255) NOT NULL,
  `final_production_stage` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `useimage` varchar(1) NOT NULL,
  `background` varchar(20) NOT NULL,
  `rank` varchar(20) NOT NULL,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `settings` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `notes` varchar(60) NOT NULL,
  `value` varchar(60) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






CREATE TABLE `sizes` (
  `size` varchar(30) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `size` (`size`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;






/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;