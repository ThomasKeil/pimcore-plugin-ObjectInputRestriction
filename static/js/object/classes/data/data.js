/**
 * Created with JetBrains PhpStorm.
 * User: thomas
 * Date: 03.09.13
 * Time: 07:08
 * To change this template use File | Settings | File Templates.
 */

pimcore.object.classes.data.input = Class.create(pimcore.object.classes.data.input, {


    getLayout: function ($super) {
        $super();
        this.createRestrictionConfig(this.datax.name);
        return this.layout;
    }
});
pimcore.object.classes.data.input.addMethods(ObjectInputRestriction.helpers.data);


pimcore.object.classes.data.textarea = Class.create(pimcore.object.classes.data.textarea, {

    getLayout: function ($super) {
        $super();
        this.createRestrictionConfig(this.datax.name);
        return this.layout;
    }
});
pimcore.object.classes.data.textarea.addMethods(ObjectInputRestriction.helpers.data);