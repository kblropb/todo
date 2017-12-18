<?php
$title = isset($data['title']) ? $data['title'] : 'Simple TODO';
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'head.php'; ?>
<body>
<div class="page-wrapper">

    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="/"><?php echo $title; ?></a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="#" data-toggle="modal" data-target="#sign-up-modal">
                        <span class="glyphicon glyphicon-user"></span> Sign Up
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#log-in-modal">
                        <span class="glyphicon glyphicon-log-in"></span> Login
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <div id="tasks">
            <h2 class="pull-left section-title">Tasks</h2>
            <a data-target="#add-task-modal" id="task-add" href="#" class="btn btn-success pull-right">+ Add
                new</a>
            <div class="clr"></div>
            <div class="table-responsive">
                <table data-url="<?php echo $taskListUrl; ?>" id="table-tasks"
                       class="table table-striped table-bordered table-tasks">
                    <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Title</th>
                        <th scope="col">Content</th>
                        <th scope="col">Label</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div id="sign-up-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <form id="sign-up-form" action="<?php echo $addUserUrl; ?>" class="form" method="post"
                      data-success="Success! Now you can login.">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">New user registration</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input data-validate="text" type="text" class="form-control" placeholder="Your name"
                                   name="name">
                        </div>
                        <div class="form-group">
                            <input data-validate="email" type="email" class="form-control" placeholder="Email"
                                   name="email">
                        </div>
                        <div class="password-group">
                            <div class="form-group">
                                <input data-validate="text" type="password" class="form-control"
                                       placeholder="Password" name="password1" id="password1">
                            </div>
                            <div class="form-group">
                                <input data-validate="function" data-function="checkPasswords" type="password"
                                       class="form-control" placeholder="Confirm password"
                                       name="password2" id="password2">
                            </div>
                        </div>
                        <div class="messages-container">

                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary pull-right">Create!</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="log-in-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <div class="modal-content">
                <form id="log-in-form" action="<?php echo $loginUrl; ?>" class="form" method="post"
                      data-callback="getTaskList">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Login</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input data-validate="email" type="email" class="form-control" placeholder="Email"
                                   name="email">
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="password"
                                   placeholder="Password" name="password" id="password">
                        </div>
                        <div class="messages-container">
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary pull-right">Log in!</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div id="add-task-modal" class="modal fade" role="dialog" data-url="<?php echo $addTaskUrl; ?>">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    <div id="remove-task-modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="<?php echo $taskRemoveUrl; ?>" data-callback="getTaskList">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Remove task?</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure?
                        <div class="messages-container"></div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger pull-right">Remove</button>
                    </div>

                    <input type="hidden" name="taskId" value="">
                </form>
            </div>
        </div>
    </div>

</div>

<?php include 'scripts.php'; ?>
</body>
</html>