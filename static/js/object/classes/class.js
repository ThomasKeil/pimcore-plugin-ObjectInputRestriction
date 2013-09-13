/**
 * Created with JetBrains PhpStorm.
 * User: thomas
 * Date: 04.09.13
 * Time: 07:11
 */


pimcore.object.classes.klass  = Class.create(pimcore.object.classes.klass, {


    initLayoutFields: function ($super) {

        remote_data = null;
        jQuery.ajax({
            url: "/plugin/ObjectInputRestriction/settings/getdata",
            async: false,
            dataType: "json",
            type: "GET",
            data: {
                id: this.data.id
            },
            success: function(data) {
                remote_data = data;
            }
        });


        var rootNode = this.tree.getRootNode();

        rootNode.objectinputrestriction_data = remote_data;
        $super();
    },

    saveOnComplete: function ($super, response) {
        $super(response);
        var configuration = Ext.encode(this.getData());
        var values = Ext.encode(this.data);

        Ext.Ajax.request({
            url: '/plugin/ObjectInputRestriction/settings/save',
            method: "post",
            params: {
                configuration: configuration,
                id: this.data.id
            },
            success: this.saveRestrictionsOnComplete.bind(this),
            failure: this.saveRestrictionsOnError.bind(this)
        });
    },

    saveRestrictionsOnComplete: function (response) {

        try {
            var res = Ext.decode(response.responseText);
            if(!res.success) {
                throw "save of restriction data was not successful, see debug.log";
            }
        } catch (e) {
            this.saveRestrictionsOnError();
        }

    },

    saveRestrictionsOnError: function () {
        pimcore.helpers.showNotification(t("error"), t("restrictions_save_error"), "error");
    }

});