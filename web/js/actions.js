$(document).ready(function () {


    $(document).on('submit', 'form', function (e) {
        e.preventDefault();
        var form = $(this);
        if (validateForm(form)) {
            sendForm(form);
        }
    });


    $(document).on('click', '.task-remove', function () {
        var element = $(this);
        var taskId = element.closest('.task').data('id');
        var modal = $(element.data('target'));
        modal.find('[name="taskId"]').val(taskId);
        modal.modal();
    });

    $(document).on('click', '.task-edit', function () {
        var element = $(this);
        var taskContainer = element.closest('.task');
        var modal = $(element.data('target'));
        var task = {
            id: taskContainer.data('id'),
            date: taskContainer.find('.task-date').text(),
            title: taskContainer.find('.task-title').text(),
            content: taskContainer.find('.task-content').text(),
            label: taskContainer.find('.task-label').data('label')
        };

        $.ajax({
            method: "POST",
            url: modal.data('url')
        })
            .done(function (response) {
                modal.find('.modal-content').html('').append(response);
                var form = modal.find('form');
                form.find('[name="taskId"]').val(task.id);
                form.find('[name="taskDate"]').val(task.date);
                form.find('[name="taskTitle"]').val(task.title);
                form.find('[name="taskContent"]').val(task.content);
                form.find('[name="taskLabel"]').val(task.label);
                modal.modal();
            })
    });

    $(document).on('click', '#task-add', function (e) {
        var element = $(this);
        var modal = $(element.data('target'));
        modal.data('taskId', null);

        $.ajax({
            method: "POST",
            url: modal.data('url')
        })
            .done(function (response) {
                // console.log(response);
                modal.find('.modal-content').html('').append(response);
            });
        modal.modal();
    });

    getTaskList();

    var labelMap = {
        0: 'New',
        1: 'In Progress',
        2: 'Done'
    };

    function getTaskList() {
        var table = $('#table-tasks');
        var url = table.data('url');

        $.ajax({
            method: 'POST',
            url: url,
            beforeSend: function () {
                // showPreloader
            }
        })
            .done(function (response) {
                var responseObject = JSON.parse(response);
                var html = '';
                $.each(responseObject.data, function (index, element) {
                    html +=
                        '<tr class="task" data-id="' + element.id + '">' +
                        '<td class="task-date">' + element.date + '</td>' +
                        '<td class="task-title">' + element.title + '</td>' +
                        '<td class="task-content">' + element.content + '</td>' +
                        '<td class="task-label" data-label="' + element.label + '"><span class="label-' + element.label + '">' + labelMap[element.label] + '</span></td>' +
                        '<td class="task-actions">' +
                        '<span class="task-edit btn btn-xs btn-info glyphicon glyphicon-pencil" data-target="#add-task-modal"></span>' +
                        '<span class="task-remove btn btn-xs btn-danger glyphicon glyphicon-trash" data-target="#remove-task-modal"></span>' +
                        '</td>' +
                        '</tr>';

                });
                table.find('tbody').html(html);

            })
            .fail(function (response) {

            })
            .always(function (response) {

            })
    }


    /* ===== FORMS ====================================================================================== */
    /* ================================================================================================== */
    $('[data-validate]').focus(function () {
            $(this).closest('.has-error').removeClass('has-error')
        }
    );

    var timeout = 0;

    function sendForm(form) {
        $.ajax({
            method: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            beforeSend: function () {
                form.find('.messages-container').removeClass('alert alert-danger alert-success').html('');
            }
        })
            .done(function (response, statusText) {
                var responseObject = JSON.parse(response);
                if (responseObject.success) {
                    form.find('.has-success').removeClass('has-success');
                    var alert = form.find('.messages-container')
                        .addClass('alert alert-success')
                        .append('<div class="success">' + responseObject.message + '</div>')
                    form[0].reset();
                    setTimeout(function () {
                        form.closest('.modal').modal('hide');
                    }, 1500);

                    if (typeof form.data('callback') !== 'undefined') {
                        eval(form.data('callback'))();
                    }
                }
                else {
                    $.each(responseObject.message, function () {
                        form.find('.messages-container').addClass('alert alert-danger').append('<div class="error">' + this + '</div>')
                    });
                }
            })
            .fail(function (response, statusText) {
                console.log(response);
                console.log(statusText);
            })
            .always(function (response, statusText) {
                if (timeout) {
                    clearTimeout(timeout);
                }
                timeout = setTimeout(function () {
                    form.find('.messages-container').removeClass('alert alert-danger alert-success').html('');
                }, 1500)
            });
    }

    function validateForm(form) {
        var elements = form.find('[data-validate]');
        var isValid = true;
        elements.each(function () {
            var element = $(this);
            if (validateElement(element)) {
                element.closest('.form-group').removeClass('has-error').addClass('has-success');
            } else {
                element.closest('.form-group').removeClass('has-success').addClass('has-error');
                isValid = false;
            }
        });

        return isValid;
    }

    function validateElement(element) {
        switch (element.data('validate')) {
            case 'text':
                return validate.validateText(element.val(), element);
            case 'email':
                return validate.validateEmail(element.val(), element);
            case 'function':
                return validate.validateFunction(element.data('function'), element);
            default:
                return false;
        }
    }

    var validate = {
        validateText: function (text, element) {
            text = text.trim();
            if ((typeof element.attr('data-empty') !== 'undefined') && (text.length === 0)) {
                return true;
            }
            else {
                var minLength = element.data("min-length") || 0;
                var maxLength = element.data("max-length") || Number.MAX_VALUE;
                return (text.length && (text.length >= minLength) && (text.length <= maxLength));
            }
        },
        validateEmail: function (email, element) {
            if ((typeof element.attr('data-empty') !== 'undefined') && (email.length === 0)) {
                return true;
            }
            else {
                var regexp = /^([а-яА-Яa-zA-Z0-9_\.\-\+])+\@(([а-яА-Яa-zA-Z0-9\-])+\.)+([а-яА-Яa-zA-Z0-9]{2,4})$/;
                return regexp.test(email);
            }
        },
        validateFunction: function (functionName, element) {
            if (typeof window[functionName] === 'function') {
                return window[functionName](element);
            } else {
                console.group('Validation warning');
                console.warn('Function "%s" not found in element: ', functionName);
                console.warn(element);
                console.groupEnd();
                return false;
            }
        }
    }

});

function checkPasswords(element) {
    var passwordGroup = element.closest('.password-group');
    var pwd1 = $('#password1').val();
    var pwd2 = $('#password2').val();
    if (pwd1.length && pwd1 === pwd2) {
        passwordGroup.find('.form-group').addClass('has-success').removeClass('has-error');
        return true;
    } else {
        passwordGroup.find('.form-group').addClass('has-error').removeClass('has-success');
        return false;
    }
}