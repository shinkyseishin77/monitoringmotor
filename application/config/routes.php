<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth
$route['auth/login']  = 'Auth/login';
$route['auth/logout'] = 'Auth/logout';

// Dashboard
$route['dashboard']   = 'Dashboard/index';
$route['']            = 'Auth/login';

// Motor
$route['motor']                    = 'Motor/index';
$route['motor/tambah']             = 'Motor/tambah';
$route['motor/simpan']             = 'Motor/simpan';
$route['motor/edit/(:num)']        = 'Motor/edit/$1';
$route['motor/update/(:num)']      = 'Motor/update/$1';
$route['motor/detail/(:num)']      = 'Motor/detail/$1';
$route['motor/hapus/(:num)']       = 'Motor/hapus/$1';

// Service
$route['service']                  = 'Service/index';
$route['service/tambah']           = 'Service/tambah';
$route['service/simpan']           = 'Service/simpan';
$route['service/edit/(:num)']      = 'Service/edit/$1';
$route['service/update/(:num)']    = 'Service/update/$1';
$route['service/detail/(:num)']    = 'Service/detail/$1';
$route['service/hapus/(:num)']     = 'Service/hapus/$1';
$route['service/update_status/(:num)'] = 'Service/update_status/$1';

// Penjadwalan
$route['penjadwalan']              = 'Penjadwalan/index';
$route['penjadwalan/tambah']       = 'Penjadwalan/tambah';
$route['penjadwalan/simpan']       = 'Penjadwalan/simpan';
$route['penjadwalan/edit/(:num)']  = 'Penjadwalan/edit/$1';
$route['penjadwalan/update/(:num)']= 'Penjadwalan/update/$1';
$route['penjadwalan/detail/(:num)']= 'Penjadwalan/detail/$1';
$route['penjadwalan/hapus/(:num)'] = 'Penjadwalan/hapus/$1';
$route['penjadwalan/selesai/(:num)']= 'Penjadwalan/selesai/$1';

// Monitoring Motor
$route['monitoring']               = 'MonitoringMotor/index';
$route['monitoring/update_status/(:num)'] = 'MonitoringMotor/update_status/$1';
$route['monitoring/riwayat/(:num)']= 'MonitoringMotor/riwayat/$1';

// Master AC  
$route['unit_ac']                  = 'MasterAC/index';
$route['unit_ac/tambah']           = 'MasterAC/tambah';
$route['unit_ac/simpan']           = 'MasterAC/simpan';
$route['unit_ac/edit/(:num)']      = 'MasterAC/edit/$1';
$route['unit_ac/update/(:num)']    = 'MasterAC/update/$1';
$route['unit_ac/detail/(:num)']    = 'MasterAC/detail/$1';
$route['unit_ac/hapus/(:num)']     = 'MasterAC/hapus/$1';

// Monitoring AC
$route['monitoring_ac']            = 'MonitoringAC/index';
$route['monitoring_ac/update_status/(:num)'] = 'MonitoringAC/update_status/$1';
$route['monitoring_ac/riwayat/(:num)'] = 'MonitoringAC/riwayat/$1';

// Laporan
$route['riwayat']                  = 'Riwayat/index';
$route['laporan_monitoring']       = 'LaporanMonitoring/index';
$route['laporan_monitoring/cetak'] = 'LaporanMonitoring/cetak';
$route['activity_log']             = 'ActivityLog/index';

// Pengaturan
$route['kelola_role']              = 'Pengaturan/kelola_role';
$route['kelola_role/simpan']       = 'Pengaturan/simpan_role';
$route['kelola_role/update/(:num)']= 'Pengaturan/update_role/$1';
$route['kelola_role/hapus/(:num)'] = 'Pengaturan/hapus_role/$1';

$route['kelola_user']              = 'Pengaturan/kelola_user';
$route['kelola_user/simpan']       = 'Pengaturan/simpan_user';
$route['kelola_user/update/(:num)']= 'Pengaturan/update_user/$1';
$route['kelola_user/hapus/(:num)'] = 'Pengaturan/hapus_user/$1';

// Notifikasi API
$route['notifikasi/get']           = 'Dashboard/get_notifikasi';
