/**
 * Created with JetBrains PhpStorm.
 * User: thomas
 * Date: 05.09.13
 * Time: 11:28
 * To change this template use File | Settings | File Templates.
 */

pimcore.object.object = Class.create(pimcore.object.object, {
    getData: function ($super) {
        remote_data = null;
        jQuery.ajax({
            url: "/plugin/ObjectInputRestriction/permissions/get",
            async: false,
            dataType: "json",
            type: "GET",
            data: {
                id: this.id
            },
            success: function(data) {
                remote_data = data;
            }
        });
        this.remote_permissions = remote_data;
        $super();
    }
});