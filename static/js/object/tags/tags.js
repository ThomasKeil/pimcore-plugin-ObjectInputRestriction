/**
 * Created with JetBrains PhpStorm.
 * User: thomas
 * Date: 03.09.13
 * Time: 07:23
 * To change this template use File | Settings | File Templates.
 */




pimcore.object.tags.input = Class.create(pimcore.object.tags.input, {
    getLayoutEdit: function ($super) {
        $super();
        if (this.object.remote_permissions[this.name] == false) this.component.hide();
        return this.component;
    }
});

pimcore.object.tags.textarea = Class.create(pimcore.object.tags.textarea, {
    getLayoutEdit: function ($super) {
        $super();
        if (this.object.remote_permissions[this.name] == false) this.component.hide();
        return this.component;
    }
});