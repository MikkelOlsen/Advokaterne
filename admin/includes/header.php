<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-xs-1 p-l-0 p-r-0 in" id="sidebar">
            <div class="list-group panel">

                <a href="?p=dashboard&view=home"><h4 class="text-center list-group-item"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $user['navn']?></h4></a>
                <a href="#menu1" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-dashboard"></i> <span class="hidden-sm-down">Blog</span> </a>
                <div class="collapse" id="menu1">
                    <a href="?p=dashboard&view=nypost" class="list-group-item" data-parent="#menu1">Ny post</a>
                    <a href="?p=dashboard&view=posts" class="list-group-item" data-parent="#menu1">Se posts</a>
                    <a href="#menu1sub2" class="list-group-item" data-toggle="collapse" aria-expanded="false">Blog Kategorier </a>
                    <div class="collapse" id="menu1sub2">
                        <a href="?p=dashboard&view=nykat" class="list-group-item" data-parent="#menu1sub2">Opret kategori</a>
                        <a href="?p=dashboard&view=viskat" class="list-group-item" data-parent="#menu1sub2">Se kategorier</a>
                    </div>
                </div>


                <a href="#menu2" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-book"></i> <span class="hidden-sm-down">Brugere </span></a>
                <div class="collapse" id="menu2">
                    <a href="?p=dashboard&view=usercreate" class="list-group-item" data-parent="#menu2">Opret ny bruger</a>
                    <a href="?p=dashboard&view=users" class="list-group-item" data-parent="#menu2">Liste af brugere</a>
                </div>


                <a href="?p=dashboard&view=information" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-film"></i> <span class="hidden-sm-down">Informations side</span></a>
                
                
                <a href="#menu3" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-book"></i> <span class="hidden-sm-down">Service </span></a>
                <div class="collapse" id="menu3">
                    <a href="?p=dashboard&view=nyservice" class="list-group-item" data-parent="#menu3">Opret ny service</a>
                    <a href="?p=dashboard&view=services" class="list-group-item" data-parent="#menu3">Liste af servicer</a>
                </div>

                <a href="#menu4" class="list-group-item collapsed" data-toggle="collapse" data-parent="#sidebar" aria-expanded="false"><i class="fa fa-book"></i> <span class="hidden-sm-down">Kundeudtalelser </span></a>
                <div class="collapse" id="menu4">
                    <a href="?p=dashboard&view=nyudtalelse" class="list-group-item" data-parent="#menu4">Opret ny kundeudtalelse</a>
                    <a href="?p=dashboard&view=udtalelser" class="list-group-item" data-parent="#menu4">Liste af kundeudtalelser</a>
                </div>



                <a href="?p=dashboard&view=beskeder" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-film"></i> <span class="hidden-sm-down">Beskeder</span></a>

                <a href="?p=dashboard&view=nyhedsbreve" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-film"></i> <span class="hidden-sm-down">Tilmeldte til nyheder</span></a>

                <a href="?p=dashboard&view=settings" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-list"></i> <span class="hidden-sm-down">Side indstillinger</span></a>
                
                <a href="?p=dashboard&view=logout" class="list-group-item collapsed" data-parent="#sidebar"><i class="fa fa-clock-o"></i> <span class="hidden-sm-down">Log af</span></a>
            </div>
        </div>
    </div>
</div>