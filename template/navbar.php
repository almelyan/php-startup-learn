<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Nearby School</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
            <?php if( isset($_SESSION['uid']) && is_numeric($_SESSION['uid']) ): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-user"></i> <?php echo $_SESSION['username'];?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">Main</a></li>
                        <?php if( $_SESSION['account'] == 'A' ): ?>
                        <li><a href="users.php">Accounts</a></li>
                        <?php endif; ?>
                        <li role="separator" class="divider"></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
            <?php else: ?>
                <li><a href="login.php">Login Member</a></li>
            <?php endif; ?>
            </ul>
        </div>


        <!--div id="navbar" class="navbar-collapse collapse">
            <form class="navbar-form navbar-right">
                <div class="form-group">
                    <input type="text" placeholder="Email" class="form-control">
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Password" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">Sign in</button>
            </form>
        </div><!--/.navbar-collapse -->
    </div>
</nav>