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
            'avatar' => '/img/avatar.png',
            'gender' => '1',
            'email_verified_at' => now(),
            'password' => bcrypt('admin'),
            'status' => 0,
        ]);
        $roles = array('Admin', 'Employee', 'Default');

        $permissions = 'a:36:{i:0;s:10:"createUser";i:1;s:10:"updateUser";i:2;s:12:"viewUserList";i:3;s:10:"deleteUser";i:4;s:11:"createGroup";i:5;s:11:"updateGroup";i:6;s:9:"viewGroup";i:7;s:11:"deleteGroup";i:8;s:11:"createBrand";i:9;s:11:"updateBrand";i:10;s:9:"viewBrand";i:11;s:11:"deleteBrand";i:12;s:14:"createCategory";i:13;s:14:"updateCategory";i:14;s:12:"viewCategory";i:15;s:14:"deleteCategory";i:16;s:11:"createStore";i:17;s:11:"updateStore";i:18;s:9:"viewStore";i:19;s:11:"deleteStore";i:20;s:15:"createAttribute";i:21;s:15:"updateAttribute";i:22;s:13:"viewAttribute";i:23;s:15:"deleteAttribute";i:24;s:13:"createProduct";i:25;s:13:"updateProduct";i:26;s:11:"viewProduct";i:27;s:13:"deleteProduct";i:28;s:11:"createOrder";i:29;s:11:"updateOrder";i:30;s:9:"viewOrder";i:31;s:11:"deleteOrder";i:32;s:11:"viewReports";i:33;s:13:"updateCompany";i:34;s:11:"viewProfile";i:35;s:13:"updateSetting";}';
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

        DB::insert("INSERT INTO `brands` (`id`, `code`, `brand`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES ('0', 'wijaya', 'wijaya', NULL, '0', NULL, '2019-08-16 17:30:00', '2019-08-16 17:30:00')");
        DB::insert("INSERT INTO `categories` (`id`, `code`, `category`, `description`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES ('0', 'f-0', 'food', NULL, '0', NULL, '2019-08-16 17:30:16', '2019-08-16 17:30:16')");
        DB::insert("INSERT INTO `locations` (`id`, `name`, `code`, `address`, `telephone`, `email`, `contact_person`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES ('0', 'thudugala', 'ktr-th', 'kinihitiyagoda, narawala,poddala,galle, house', '0711513461', 'asda@gmail.com', 'prasnanna', '1', '0', NULL, '2019-08-16 17:30:50', '2019-08-16 17:30:50')");
        DB::insert("INSERT INTO `products` (`id`, `barcode`, `sku`, `item_code`, `name`, `short_name`, `description`, `img_url`, `category`, `brand`, `selling_price`, `cost_price`, `weight`, `unit`, `availability`, `reorder_level`, `reorder_activation`, `tax`, `tax_method`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES ('0', NULL, '121', 'ch250', 'chili pieces 250', 'chili pieces 250', '', 'products/default.jpg', '1', '1', '100', '80', '0.25', '3', '0', '0', '1', '0', '1', '0', NULL, '2019-08-16 17:33:24', '2019-08-16 17:33:24'), ('0', NULL, '3s', 'nd5', 'noodles 5KG', 'noodles 5KG', '', 'products/default.jpg', '1', '1', '300', '250', '5', '3', '0', '0', '1', '0', '2', '0', NULL, '2019-08-16 17:35:08', '2019-08-16 17:35:08')");
        DB::insert("INSERT INTO `supplier` (`id`, `company`, `name`, `address`, `phone`, `email`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES (NULL, 'wijaya', 'wijaya', 'shdas,da asd,asdadh', '0711513461', NULL, '0', NULL, NULL, NULL)");
        DB::insert("INSERT INTO `po_header` (`id`, `location`, `supplier`, `referenceCode`, `due_date`, `tax`, `tax_percentage`, `discount`, `discount_val_or_per`, `grand_total`, `status`, `remark`, `deleted_at`, `created_at`, `updated_at`) VALUES ('0', '1', '1', 'PO-000001', '2019-08-17', '0', '0', '0', '0', '8000', '1', NULL, NULL, '2019-08-17 04:41:39', '2019-08-18 06:51:36'), ('0', '1', '1', 'PO/M-000002', '2019-08-17', '0', '0', '0', '0', '800', '1', NULL, NULL, '2019-08-17 05:13:02', '2019-08-17 10:25:33')");
        DB::insert("INSERT INTO `po_details` (`id`, `po_header`, `item_id`, `cost_price`, `qty`, `received_qty`, `tax_val`, `tax_percentage`, `discount`, `sub_total`, `created_at`, `updated_at`) VALUES ('0', '1', '1', '80', '100', '30', '0', '0', '0', '8000', '2019-08-17 04:41:39', '2019-08-18 07:03:35'), ('0', '2', '1', '80', '10', '10', '0', '0', '0', '800', '2019-08-17 05:13:02', '2019-08-17 10:25:33')");
        DB::insert("INSERT INTO `products_supplier` (`products_id`, `supplier_id`, `created_at`, `updated_at`) VALUES ('1', '1', NULL, NULL), 
('1', '2', NULL, NULL), ('2', '1', NULL, NULL), ('2', '2', NULL, NULL)");
        DB::insert("INSERT INTO `stock` (`id`, `po_reference_code`, `receive_code`, `receive_date`, `location`, `remarks`, `status`, `deleted_at`, `created_at`, `updated_at`) VALUES 
('0', 'PO/M-000002', 'PR-000001', '2019-08-17', '1', NULL, '0', NULL, '2019-08-17 10:25:33', '2019-08-17 10:25:33'),
 ('0', 'PO-000001', 'PR-000002', '2019-08-19', '1', 'note fpr partailly 1', '0', NULL, '2019-08-18 06:35:08', '2019-08-18 06:35:08'), 
 ('0', 'PO-000001', 'PR-000003', '2019-08-18', '1', NULL, '0', NULL, '2019-08-18 06:38:40', '2019-08-18 06:38:40'), 
 ('0', 'PO-000001', 'PR-000004', '2019-08-18', '1', NULL, '0', NULL, '2019-08-18 06:51:36', '2019-08-18 06:51:36'),
 ('0', 'PO-000001', 'PR-000005', '2019-08-18', '1', NULL, '0', NULL, '2019-08-18 06:53:48', '2019-08-18 06:53:48'),
  ('0', 'PO-000001', 'PR-000006', '2019-08-18', '1', NULL, '0', NULL, '2019-08-18 06:54:07', '2019-08-18 06:54:07'), 
  ('0', 'PO-000001', 'PR-000007', '2019-08-18', '1', NULL, '0', NULL, '2019-08-18 06:54:35', '2019-08-18 06:54:35'), 
  ('0', 'PO-000001', 'PR-000008', '2019-08-18', '1', NULL, '0', NULL, '2019-08-18 07:03:35', '2019-08-18 07:03:35')");
        DB::insert("INSERT INTO `stock_items` (`id`, `stock_id`, `item_id`, `qty`, `method`, `created_at`, `updated_at`) VALUES 
('0', '1', '2', '10', 'A', '2019-08-17 10:25:33', '2019-08-17 10:25:33'), ('0', '2', '1', '5', 'A', '2019-08-18 06:35:08', '2019-08-18 06:35:08'),
 ('0', '3', '1', '6', 'A', '2019-08-18 06:38:40', '2019-08-18 06:38:40'), ('0', '4', '1', '2', 'A', '2019-08-18 06:51:36', '2019-08-18 06:51:36'),
  ('0', '5', '1', '1', 'A', '2019-08-18 06:53:48', '2019-08-18 06:53:48'), ('0', '6', '1', '6', 'A', '2019-08-18 06:54:35', '2019-08-18 06:54:35'),
   ('0', '7', '1', '10', 'A', '2019-08-18 07:03:35', '2019-08-18 07:03:35')");

        DB::insert("INSERT INTO `tax_profiles` (`id`, `name`, `code`, `value`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES ('0', 'No Vat', '0%', '0', 'Percentage', '0', NULL, '2019-08-20 17:57:51', '2019-08-28 11:21:10', NULL, NULL, NULL)");
        DB::insert("INSERT INTO `tax_profiles` (`id`, `name`, `code`, `value`, `type`, `status`, `deleted_at`, `created_at`, `updated_at`, `created_by`, `updated_by`, `deleted_by`) VALUES ('0', '20 % tax', '20 %', '20', 'Percentage', '0', NULL, '2019-08-28 11:22:35', '2019-08-28 11:22:35', NULL, NULL, NULL)");
    }
}
