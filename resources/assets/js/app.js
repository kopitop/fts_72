
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('jquery-countdown');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('example', require('./components/Example.vue'));

const app = new Vue({
    el: '#app'
});

$(document).ready(function () {
    //Sidebar menu
    $('ul').has('li.active').show();

    $('ul.sidebar li ul li').on('click', function (e) {
        e.stopPropagation();
    });

    $('ul.sidebar>li').on('click', function (e) {
        $('.sidebar li ul').each(function (index, element) {
            if ($(element).has('li.active').length === 0) {
                $(element).hide(400);
            };
        })
        $(this).find('ul').show(400);
    });

    $(document).on('click', function (e) {
        if ($('.sidebar').has(e.target).length === 0 && e.target) {
            $('.sidebar li ul').each(function (index, element) {
                if ($(element).has('li.active').length === 0) {
                    $(element).hide(400);
                };
            })
        }
    });

    $(document).on('click', '.status', function () {
        $('.status').on('click', function () {
            $(this).hide(400);
        });
    });

    //Prompt confirm dialog
    $('.confirm').not('delete-account').on('click', function () {
        return confirm(confirmation);
    });

    //Add answer for question
    $('#add-answer').on('click', function (e) {
        e.preventDefault();

        add_fields('#answer-section', '\
                <div class="form-group">\
                    <label class="col-sm-2 control-label">' + answer + '</label>\
                    <div class="col-sm-6">\
                        <input name=\'answer[index][content]\' type="text" class="form-control" placeholder="' 
                        + content + 
                        '">\
                    </div>\
                    <div class="checkbox-remove">\
                        <div class="col-sm-2">\
                            <div class="checkbox">\
                                <label>\
                                    <input type="hidden" name=\'answer[index][is_correct]\' value="0">\
                                    <input name=\'answer[index][is_correct]\' class="is_correct" type="checkbox" value=1 >\
                                    ' + is_correct + '\
                                </label>\
                            </div>\
                        </div>\
                        <div class="col-sm-2">\
                            <button class="remove-answer btn btn-default">\
                                ' + remove + '\
                            </button>\
                        </div>\
                    </div>\
                </div>\
            ');
    });

    $('#question-type').on('change', function (e) {
        if ($(this).val() == questionType.text) {
            $('.remove-answer').trigger('click');
            $('#add-answer').trigger('click');
            $('#add-answer').hide();
            $(".checkbox-remove").hide();
        } else {
            $(".is_correct").prop("checked", false);
            $('#add-answer').show();
            $('.checkbox-remove').show();
        }
    });

    $('#answer-section').on('DOMSubtreeModified', function() { 
        if ($(this).val() == questionType.singlechoice) {
                $('.is_correct:first').prop('checked', true);
            }
    });

    function add_fields(link, content) {
        var randomIndex = new Date().getTime();

        $(link).append(content.replace(/index/g, randomIndex));

        if ($('#question-type').val() == questionType.text) {
            $('.is_correct').prop('checked', true);
        }
    }

    $(document).on('click', '.remove-answer', function (e) {
        e.preventDefault();
        remove_fields(this);
    })

    function remove_fields(link) {
        $(link).closest(".form-group").remove();
    }

    $(document).on('change','.is_correct', function(){
    if ($('#question-type').val() == questionType.singlechoice){
            $('.is_correct').not(this).prop('checked', false);
            $(this).prop('checked', true);
        }
    });

    $('#delete-account').on('click', function () {
        event.preventDefault ();
        if (confirm($deleteConfirm)) {
            $('#delete-account-form').submit();
        }

        return false;
    });

    //countdown
    if (typeof isTesting !== 'undefined' && isTesting) {
        var now = new Date();
        var over = new Date(now.getTime() + remainingTime * 1000);

        $('div#clock').countdown(over, function (e) {
            $(this).text(e.strftime('%H:%M:%S'))
        })
            .on('finish.countdown', function (e) {
                $('#time_spent').val(duration - remainingTime);
                $('#exam').submit();
            })
            .on('update.countdown', function (e) {
                remainingTime = e.offset.totalSeconds;
            });

        var updateTimeSpent = false;

        $('input[name="commit"]').on('click', function (e) {
            if (updateTimeSpent) {
                updateTimeSpent = false;

                return true;
            }
            e.preventDefault();
            $('#time_spent').val(duration - remainingTime);
            updateTimeSpent = true;
            $(this).click();
        })

        $(window).bind('beforeunload',function (e) {
            $('#time_spent').val(duration - remainingTime);
            var formData = $('#exam').serializeArray();
            $.ajax({
                method: 'POST',
                url: link,
                data: formData,
            })
                .done(function (msg) {
                    return true;
                });

            return alert;
        });
    } else {
        $('.answer-container input[type="text"]').prop('disabled', true);
        $('.answer-container input[type="radio"]').prop('disabled', true);
        $('.answer-container input[type="checkbox"]').not('.check-text').prop('disabled', true);
    }

    if (typeof isChecked !== 'undefined' && isChecked) {
        $('#check').remove();
        $('.answer-container input').prop('disabled', true);
    }
})
