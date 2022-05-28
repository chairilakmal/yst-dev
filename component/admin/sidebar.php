<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-background elevation-4">
    <!-- Brand Logo -->

    <a href="dashboard-admin.php" class="brand-link">
        <img src="../../img/logo-only.svg" class="brand-image mt-1">
        <span class="brand-text font-weight-bold mt-2"><i>Dashboard Admin</i></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php if (
                    $backUrl == "/yst-dev/admin/berita/" ||
                    $backUrl == "/yst-dev/admin/berita/input.php" ||
                    $backUrl == "/yst-dev/admin/berita/edit.php"
                ) {
                    echo '<li class="nav-item nav-item-sidebar  menu-open">
                    <a href="../berita/" class="nav-link side-icon active">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Berita
                        </p>
                    </a>
                </li>';
                } else {
                    echo '<li class="nav-item nav-item-sidebar  menu-open">
                    <a href="../berita/" class="nav-link side-icon">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Berita
                        </p>
                    </a>
                </li>';
                }
                ?>

                <?php if (
                    $backUrl == "/yst-dev/admin/donasi/" ||
                    $backUrl == "/yst-dev/admin/donasi/input.php" ||
                    $backUrl == "/yst-dev/admin/donasi/edit.php"
                ) {
                    echo '<li class="nav-item nav-item-sidebar">
                    <a href="../donasi/" class="nav-link active side-icon">
                        <i class="nav-icon fas fa-donate"></i>
                        <p>
                            Donasi
                        </p>
                    </a>
                </li>';
                } else {
                    echo '<li class="nav-item nav-item-sidebar">
                    <a href="../donasi/" class="nav-link side-icon">
                        <i class="nav-icon fas fa-donate"></i>
                        <p>
                            Donasi
                        </p>
                    </a>
                </li>';
                }
                ?>

                <?php if (
                    $backUrl == "/yst-dev/admin/relawan/" ||
                    $backUrl == "/yst-dev/admin/relawan/input.php" ||
                    $backUrl == "/yst-dev/admin/relawan/edit.php"
                ) {
                    echo '<li class="nav-item nav-item-sidebar">
                    <a href="../relawan/" class="nav-link active side-icon">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Relawan
                        </p>
                    </a>
                </li>';
                } else {
                    echo '<li class="nav-item nav-item-sidebar">
                    <a href="../relawan/" class="nav-link side-icon">
                        <i class="nav-icon fas fa-user-plus"></i>
                        <p>
                            Relawan
                        </p>
                    </a>
                </li>';
                }
                ?>

                <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>

                    <?php if (
                        $backUrl == "/yst-dev/admin/beasiswa/" ||
                        $backUrl == "/yst-dev/admin/beasiswa/input.php" ||
                        $backUrl == "/yst-dev/admin/beasiswa/edit.php"
                    ) {
                        echo '<li class="nav-item nav-item-sidebar">
                        <a href="../beasiswa/" class="active nav-link side-icon">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Beasiswa
                            </p>
                        </a>
                    </li>';
                    } else {
                        echo '<li class="nav-item nav-item-sidebar">
                        <a href="../beasiswa/" class="nav-link side-icon">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Beasiswa
                            </p>
                        </a>
                    </li>';
                    }
                    ?>

                    <?php if (
                        $backUrl == "/yst-dev/admin/kelola-user/" ||
                        $backUrl == "/yst-dev/admin/kelola-user/input.php" ||
                        $backUrl == "/yst-dev/admin/kelola-user/edit.php" ||
                        $backUrl == "/yst-dev/admin/non-aktif/" ||
                        $backUrl == "/yst-dev/admin/non-aktif/input.php" ||
                        $backUrl == "/yst-dev/admin/non-aktif/edit.php"
                    ) {
                        echo '<li class="nav-item nav-item-sidebar">
                        <a class="nav-link active side-icon dropdown-toggle" data-toggle="collapse" href="#menu-user" role="button" aria-controls="menu-user">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Users</p>
                        </a>
                        <div class="collapse " id="menu-user">
                            <div class="row py-2 ml-2">
                                <a href="../kelola-user/" class="nav-link side-icon">

                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        User Aktif
                                    </p>
                                </a>
                            </div>
                            <div class="row py-2 ml-2">
                                <a href="../non-aktif/" class="nav-link side-icon">
                                    <i class="nav-icon fas fa-user-slash"></i>
                                    <p>
                                        User Non Aktif
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>';
                    } else {
                        echo '<li class="nav-item nav-item-sidebar">
                        <a class="nav-link side-icon dropdown-toggle" data-toggle="collapse" href="#menu-user" role="button" aria-controls="menu-user">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>Users</p>
                        </a>
                        <div class="collapse " id="menu-user">
                            <div class="row py-2 ml-2">
                                <a href="../kelola-user/" class="nav-link side-icon">

                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        User Aktif
                                    </p>
                                </a>
                            </div>
                            <div class="row py-2 ml-2">
                                <a href="../non-aktif/" class=" nav-link side-icon">
                                    <i class="nav-icon fas fa-user-slash"></i>
                                    <p>
                                        User Non Aktif
                                    </p>
                                </a>
                            </div>
                        </div>
                    </li>';
                    }
                    ?>
                <?php } ?>

                <?php if (
                    $backUrl == "/yst-dev/admin/program-donasi/" ||
                    $backUrl == "/yst-dev/admin/program-donasi/input.php" ||
                    $backUrl == "/yst-dev/admin/program-donasi/edit.php" ||
                    $backUrl == "/yst-dev/admin/program-relawan/" ||
                    $backUrl == "/yst-dev/admin/program-relawan/input.php" ||
                    $backUrl == "/yst-dev/admin/program-relawan/edit.php"
                ) {
                    echo '<li class="nav-item nav-item-sidebar">
                    <a class="nav-link side-icon active dropdown-toggle" data-toggle="collapse" href="#menu-cf" role="button" aria-controls="menu-cf">
                        <i class="nav-icon fa fa-plus-square" aria-hidden="true"></i>
                        <p>Crowdfunding</p>
                    </a>
                    <div class="collapse " id="menu-cf">
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../program-donasi/">
                                <i class="nav-icon fa fa-donate"></i>
                                Program Donasi
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../program-relawan/">
                                <i class="nav-icon fas fa-user-plus"></i>
                                Program Relawan
                            </a>
                        </div>
                    </div>
                </li>';
                } else {
                    echo '<li class="nav-item nav-item-sidebar">
                    <a class="nav-link side-icon dropdown-toggle" data-toggle="collapse" href="#menu-cf" role="button" aria-controls="menu-cf">
                        <i class="nav-icon fa fa-plus-square" aria-hidden="true"></i>
                        <p>Crowdfunding</p>
                    </a>
                    <div class="collapse " id="menu-cf">
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../program-donasi/">
                                <i class="nav-icon fa fa-donate"></i>
                                Program Donasi
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../program-relawan/">
                                <i class="nav-icon fas fa-user-plus"></i>
                                Program Relawan
                            </a>
                        </div>
                    </div>
                </li>';
                }
                ?>

                <?php if (
                    $backUrl == "/yst-dev/admin/laporan/laporan-donasi.php" ||
                    $backUrl == "/yst-dev/admin/laporan/laporan-relawan.php" ||
                    $backUrl == "/yst-dev/admin/laporan/laporan-program-donasi.php" ||
                    $backUrl == "/yst-dev/admin/laporan/laporan-program-relawan.php" ||
                    $backUrl == "/yst-dev/admin/laporan/laporan-bulanan.php"

                ) {
                    echo ' <li class="nav-item nav-item-sidebar">
                    <a class="nav-link active side-icon dropdown-toggle" data-toggle="collapse" href="#menu-laporan" role="button" aria-controls="menu-laporan">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Laporan</p>
                    </a>
                    <div class="collapse" id="menu-laporan">
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-donasi.php">
                                <i class="nav-icon fa fa-calendar-plus-o"></i>
                                Lp. Donasi
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-relawan.php">
                                <i class="nav-icon fa fa-calendar-plus-o"></i>
                                Lp. Relawan
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-program-donasi.php">
                                <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                Lp. Program Donasi
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-program-relawan.php">
                                <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                Lp. Program Relawan
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-bulanan.php">
                                <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                Lp. Bulanan
                            </a>
                        </div>
                    </div>
                </li>';
                } else {
                    echo ' <li class="nav-item nav-item-sidebar">
                    <a class="nav-link side-icon dropdown-toggle" data-toggle="collapse" href="#menu-laporan" role="button" aria-controls="menu-laporan">
                        <i class="nav-icon fas fa-book"></i>
                        <p>Laporan</p>
                    </a>
                    <div class="collapse" id="menu-laporan">
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-donasi.php">
                                <i class="nav-icon fa fa-calendar-plus-o"></i>
                                Lp. Donasi
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-relawan.php">
                                <i class="nav-icon fa fa-calendar-plus-o"></i>
                                Lp. Relawan
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-program-donasi.php">
                                <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                Lp. Program Donasi
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-program-relawan.php">
                                <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                Lp. Program Relawan
                            </a>
                        </div>
                        <div class="row py-2 ml-2">
                            <a class="nav-item side-icon ml-3" href="../laporan/laporan-bulanan.php">
                                <i class="nav-icon fa fa-calendar-check-o" aria-hidden="true"></i>
                                Lp. Bulanan
                            </a>
                        </div>
                    </div>
                </li>';
                }
                ?>

                <?php if ($_SESSION['level_user'] == 1 || $_SESSION['level_user'] == 2) { ?>
                    <?php if (
                        $backUrl == "/yst-dev/admin/kategori-donasi/" ||
                        $backUrl == "/yst-dev/admin/kategori-donasi/input.php" ||
                        $backUrl == "/yst-dev/admin/kategori-donasi/edit.php" ||
                        $backUrl == "/yst-dev/admin/kategori-relawan/" ||
                        $backUrl == "/yst-dev/admin/kategori-relawan/input.php" ||
                        $backUrl == "/yst-dev/admin/kategori-relawan/edit.php"

                    ) {
                        echo '<li class="nav-item nav-item-sidebar">
                        <a class="nav-link active side-icon dropdown-toggle" data-toggle="collapse" href="#menu-master" role="button" aria-controls="menu-master">
                            <i class="nav-icon fa fa-star"></i>
                            <p>Menu Master</p>
                        </a>
                        <div class="collapse" id="menu-master">
                            <div class="row py-2 ml-2">
                                <a class="nav-item side-icon ml-3" href="../kategori-donasi/">
                                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                                    Kategori Donasi
                                </a>
                            </div>
                            <div class="row py-2 ml-2">
                                <a class="nav-item side-icon ml-3" href="../kategori-relawan/">
                                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                                    Kategori Relawan
                                </a>
                            </div>
                        </div>
                    </li>';
                    } else {
                        echo '<li class="nav-item nav-item-sidebar">
                        <a class="nav-link side-icon dropdown-toggle" data-toggle="collapse" href="#menu-master" role="button" aria-controls="menu-master">
                            <i class="nav-icon fa fa-star"></i>
                            <p>Menu Master</p>
                        </a>
                        <div class="collapse" id="menu-master">
                            <div class="row py-2 ml-2">
                                <a class="nav-item side-icon ml-3" href="../kategori-donasi/">
                                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                                    Kategori Donasi
                                </a>
                            </div>
                            <div class="row py-2 ml-2">
                                <a class="nav-item side-icon ml-3" href="../kategori-relawan/">
                                    <i class="nav-icon fa fa-plus" aria-hidden="true"></i>
                                    Kategori Relawan
                                </a>
                            </div>
                        </div>
                    </li>';
                    }
                    ?>
                <?php } ?>



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>