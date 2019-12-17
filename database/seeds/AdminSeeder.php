<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'avatar' => '/avatars/avatar.png',
            'gender' => '1',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'status' => 0,
        ]);
        $roles = array(
            'Admin',
            'Manager',
            'Accountant',
            'WareHouse Officer',
            'Sales Person',
            'Guest');

        $permissions = 'a:89:{i:0;s:10:"createUser";i:1;s:10:"updateUser";i:2;s:8:"viewUser";i:3;s:10:"deleteUser";i:4;s:10:"createRole";i:5;s:10:"updateRole";i:6;s:8:"viewRole";i:7;s:10:"deleteRole";i:8;s:11:"createBrand";i:9;s:11:"updateBrand";i:10;s:9:"viewBrand";i:11;s:11:"deleteBrand";i:12;s:14:"createCategory";i:13;s:14:"updateCategory";i:14;s:12:"viewCategory";i:15;s:14:"deleteCategory";i:16;s:12:"createBiller";i:17;s:12:"updateBiller";i:18;s:10:"viewBiller";i:19;s:12:"deleteBiller";i:20;s:14:"createCustomer";i:21;s:14:"updateCustomer";i:22;s:12:"viewCustomer";i:23;s:14:"deleteCustomer";i:24;s:14:"createSupplier";i:25;s:14:"updateSupplier";i:26;s:12:"viewSupplier";i:27;s:14:"deleteSupplier";i:28;s:15:"createWarehouse";i:29;s:15:"updateWarehouse";i:30;s:13:"viewWarehouse";i:31;s:15:"deleteWarehouse";i:32;s:13:"createProduct";i:33;s:13:"updateProduct";i:34;s:11:"viewProduct";i:35;s:13:"deleteProduct";i:36;s:11:"createOrder";i:37;s:11:"updateOrder";i:38;s:9:"viewOrder";i:39;s:11:"deleteOrder";i:40;s:10:"createSale";i:41;s:10:"updateSale";i:42;s:8:"viewSale";i:43;s:10:"deleteSale";i:44;s:14:"createTransfer";i:45;s:14:"updateTransfer";i:46;s:12:"viewTransfer";i:47;s:14:"deleteTransfer";i:48;s:16:"createAdjustment";i:49;s:16:"updateAdjustment";i:50;s:14:"viewAdjustment";i:51;s:16:"deleteAdjustment";i:52;s:13:"createReturns";i:53;s:13:"updateReturns";i:54;s:11:"viewReturns";i:55;s:13:"deleteReturns";i:56;s:9:"createTax";i:57;s:9:"updateTax";i:58;s:7:"viewTax";i:59;s:9:"deleteTax";i:60;s:10:"viewPeople";i:61;s:12:"viewSettings";i:62;s:11:"viewReports";i:63;s:20:"warehouseStockReport";i:64;s:20:"productQualityAlerts";i:65;s:14:"productsReport";i:66;s:17:"adjustmentsReport";i:67;s:14:"categoryReport";i:68;s:12:"brandsReport";i:69;s:10:"dailySales";i:70;s:12:"monthlySales";i:71;s:11:"salesReport";i:72;s:14:"paymentsReport";i:73;s:14:"dailyPurchases";i:74;s:16:"monthlyPurchases";i:75;s:15:"purchasesReport";i:76;s:15:"customersReport";i:77;s:15:"suppliersReport";i:78;s:13:"notifications";i:79;s:14:"quantityAlerts";i:80;s:18:"newRegisteredUsers";i:81;s:9:"dashChart";i:82;s:7:"dashTop";i:83;s:14:"poStockReceive";i:84;s:9:"poApprove";i:85;s:6:"poMail";i:86;s:9:"salesMail";i:87;s:13:"transfersMail";i:88;s:11:"viewProfile";}';
        foreach ($roles as $role):
            Role::create(
                [
                    'name' => $role,
                    'permissions' => ($role == 'Admin') ? $permissions : ''
                ]
            );
        endforeach;

        DB::table('role_user')->insert(
            [
                'user_id' => 1,
                'role_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::insert("INSERT INTO `brands` (`id`, `code`, `brand`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
 ('1', 'Wijaya', 'Wijaya', NULL, '0', NULL, '2019-08-16 17:30:00', '2019-08-16 17:30:00'),
 ('2', 'Freelan', 'Freelan', NULL, '0', NULL, '2019-08-16 17:30:00', '2019-08-16 17:30:00')
 ");
        DB::insert("INSERT INTO `categories` (`id`, `code`, `category`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES 
('1', 'E-0', 'Chili Powder', NULL, '0', NULL, '2019-08-16 17:30:16', '2019-08-16 17:30:16'),
('2', 'E-0', 'Noodles', NULL, '0', NULL, '2019-08-16 17:30:16', '2019-08-16 17:30:16')
");
        DB::insert("INSERT INTO `locations` (`id`, `name`, `code`, `address`, `telephone`, `email`, `contact_person`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
 ('1', 'Kalegana', 'W-KLG', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'harshan.dilantha@gmail.com', 'prasnanna', '1', '0', NULL, '2019-08-16 17:30:50', '2019-08-16 17:30:50'),
 ('2', 'Karapitiya', 'W-KRPT', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'harshan.dilantha@gmail.com', 'prasnanna', '1', '0', NULL, '2019-08-16 17:30:50', '2019-08-16 17:30:50')
 ");
        DB::insert("INSERT INTO `products` (`id`, `barcode`, `sku`, `item_code`, `name`, `short_name`, `description`, `img_url`, `category`, `brand`, `selling_price`, `cost_price`, `weight`, `unit`, `availability`, `reorder_level`, `reorder_activation`, `tax`, `tax_method`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES 
('1', NULL, '121', 'ch250', 'chili pieces 250', 'chili pieces 250', '', 'products/default.jpg', '1', '1', '100', '80', '0.25', '3', '0', '0', '1', '0', '1', '0', NULL, '2019-08-16 17:33:24', '2019-08-16 17:33:24'), 
('2', NULL, '3s', 'nd5', 'noodles 5KG', 'noodles 5KG', '', 'products/default.jpg', '1', '1', '300', '250', '5', '3', '0', '0', '1', '0', '2', '0', NULL, '2019-08-16 17:35:08', '2019-08-16 17:35:08')");

        DB::insert("INSERT INTO `supplier` (`id`, `company`, `name`, `address`, `phone`, `email`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES
 (NULL, 'wijaya', 'wijaya-Paranagama', 'wijaya-Paranagama , address, Galle', '0711513461', NULL, '0', NULL, NULL, NULL),
 (NULL, 'wijaya', 'wijaya-Amarathunga', 'wijaya-Amarathunga , address, Galle', '0711513461', NULL, '0', NULL, NULL, NULL),
 (NULL, 'wijaya', 'Freelan-Rajapaksha', 'Freelan-Rajapaksha , address, Galle', '0711513461', NULL, '0', NULL, NULL, NULL)
 ");
//        DB::insert("INSERT INTO `po_header` (`id`, `location`, `supplier`, `referenceCode`, `due_date`, `tax`, `tax_percentage`, `discount`, `discount_val_or_per`, `grand_total`, `status`, `remark`, `deleted_at`, `created_at`, `updated_at`) VALUES ('0', '1', '1', 'PO-000001', '2019-08-17', '0', '0', '0', '0', '8000', '1', NULL, NULL, '2019-08-17 04:41:39', '2019-08-18 06:51:36'), ('0', '1', '1', 'PO/M-000002', '2019-08-17', '0', '0', '0', '0', '800', '1', NULL, NULL, '2019-08-17 05:13:02', '2019-08-17 10:25:33')");
//        DB::insert("INSERT INTO `po_details` (`id`, `po_header`, `item_id`, `cost_price`, `qty`, `received_qty`, `tax_val`, `tax_percentage`, `discount`, `sub_total`, `created_at`, `updated_at`) VALUES ('0', '1', '1', '80', '100', '30', '0', '0', '0', '8000', '2019-08-17 04:41:39', '2019-08-18 07:03:35'), ('0', '2', '1', '80', '10', '10', '0', '0', '0', '800', '2019-08-17 05:13:02', '2019-08-17 10:25:33')");
        DB::insert("INSERT INTO `products_supplier` (`products_id`, `supplier_id`, `created_at`, `updated_at`) VALUES 
('1', '1', NULL, NULL), 
('1', '2', NULL, NULL), 
('2', '2', NULL, NULL), 
('2', '3', NULL, NULL)
");

        DB::insert("INSERT INTO `tax_profiles` (`id`, `name`, `code`, `value`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES 
('0', 'No Tax', '0%', '0', 'Percentage', '0', NULL, '2019-08-20 17:57:51', '2019-08-28 11:21:10', NULL, NULL, NULL),
('0', '20 % tax', '20 %', '20', 'Percentage', '0', NULL, '2019-08-28 11:22:35', '2019-08-28 11:22:35', NULL, NULL, NULL)
");
    }
}
