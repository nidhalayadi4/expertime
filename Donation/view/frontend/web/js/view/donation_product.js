define([
    "jquery",
    'ko',
    'mage/translate',
    "mage/storage",
    "mage/validation",
    'Magento_Checkout/js/action/get-totals',
    'Magento_Customer/js/customer-data'
], function ($, ko, $t, storage, validation, getTotalsAction, customerData) {

    return function (config) {

        const model = {
            form: {
                main: $(config.donationForm),
                cart: $(config.cartForm),
                button: $('button', config.donationForm),
                action: ko.observable(''),
                actionMode: $('input[name=actionMode]', config.donationForm),
                addAction: $(config.donationForm).attr('action'),
                delAction: $(config.donationForm).data('delete-action'),
                // delButtonTitle: $t('Cancel my donation'), // not working
                addButtonTitle: "Faire un don",
                delButtonTitle: "J'annule mon don",
                messageError: $(config.messageError),
                messageSuccess: $(config.messageSuccess)
            }
        };

        if ('add' == model.form.actionMode.val()) {
            model.form.action(model.form.addAction);
        } else {
            model.form.action(model.form.delAction);
        }

        model.form.main.submit(function (e) {

            const data = $(this).serialize();

            $.ajax({
                type: "POST",
                url: model.form.action(),
                data: data,
                showLoader: true,
                success: function(res) {
                    if (res.success) {
                        model.form.button
                            .removeClass('primary')
                            .addClass('remove')
                            .text(model.form.delButtonTitle);

                        model.form.action(model.form.delAction);
                        model.form.messageError.addClass('no-display');
                        if (res.success) model.form.messageSuccess.text(res.success).removeClass('no-display');
                    } else {
                        model.form.button
                            .removeClass('remove')
                            .addClass('primary')
                            .text(model.form.addButtonTitle);

                        model.form.action(model.form.addAction);
                        model.form.messageSuccess.addClass('no-display');
                        if (res.error) model.form.messageError.text(res.error).removeClass('no-display');
                    }

                    // TODO: reload cart items reponse.
                    // const parsedResponse = $.parseHTML(res);
                    // const result = $(parsedResponse).find(model.form.cartForm);
                    // $(model.form.cartForm).replaceWith(result);

                    /* message section*/
                    // var messages = $.cookieStorage.get('mage-messages');
                    // if (!_.isEmpty(messages)) {
                    //     customerData.set('messages', {messages: messages});
                    //     $.cookieStorage.set('mage-messages', '');
                    // }
                    // var messages_section = ['messages'];
                    //customerData.invalidate(messages_sections);
                    // customerData.reload(messages_section);

                    /* Minicart reloading */
                    const sections = ['cart'];
                    customerData.invalidate(sections);
                    customerData.reload(sections, true);

                    /* Totals summary reloading */
                    const deferred = $.Deferred();
                    getTotalsAction([], deferred);

                    //TODO: remove temp action
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                },
                error: function (xhr, status, error) {
                    const err = eval("(" + xhr.responseText + ")");
                    console.log(err.Message);
             }
            });

            e.preventDefault();
            return false;
        });

        return model;
    }
});
