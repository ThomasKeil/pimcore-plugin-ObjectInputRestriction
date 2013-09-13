/**
 * Created with JetBrains PhpStorm.
 * User: thomas
 * Date: 12.09.13
 * Time: 07:14
 * To change this template use File | Settings | File Templates.
 */

var classes_data = new Array("input", "textarea");

for (var i = 0; i < classes_data.length; ++i) {
    var class_name = classes_data[i];
    pimcore.object.classes.data[class_name] = Class.create(pimcore.object.classes.data[class_name], {
        getLayout: function ($super) {
            $super();
            this.createRestrictionConfig(this.datax.name); // From ObjectInputRestriction.helpers.data
            return this.layout;
        }
    });
    pimcore.object.classes.data[class_name].addMethods(ObjectInputRestriction.helpers.data);

    pimcore.object.tags[class_name] = Class.create(pimcore.object.tags[class_name], {
        getLayoutEdit: function ($super) {
            $super();
            if (this.object.remote_permissions[this.name] == false) this.component.hide();
            return this.component;
        }
    });

}