/**
 * Created with JetBrains PhpStorm.
 * User: thomas
 * Date: 04.09.13
 * Time: 10:48
 * To change this template use File | Settings | File Templates.
 */


/**
 * NOTE: This helper-methods are added to the classes derived from pimcore.object.classes.data
 * pimcore.object.tags.localizedfields
 */


pimcore.registerNS("ObjectInputRestriction.helpers.data");
ObjectInputRestriction.helpers.data = {
    createRestrictionConfig: function (title) {
        var node = this.treeNode;
        while (node.parentNode != null) {
            node = node.parentNode;
        }

        var users_store =new Ext.data.ArrayStore({
            sortInfo: { field: "value", direction: "ASC" },
            fields: [
                {name: "key", type: "int"},
                {name: "value", type: "string"}
            ]
        });


        var user_value = 0;
        var roles_value = 0;

        var user_options = node.objectinputrestriction_data["users"];


        if (node.objectinputrestriction_data && node.objectinputrestriction_data["fields"][title]) {
            user_value = node.objectinputrestriction_data["fields"][title]["users"];
        }

        if (node.objectinputrestriction_data && node.objectinputrestriction_data["fields"][title]) {
            roles_value = node.objectinputrestriction_data["fields"][title]["roles"];
        }

        for (var i = 0; i < user_options.length; i++) {
            var record = new users_store.recordType({id: user_options[i].id, value: user_options[i].value});
            users_store.add(record);
        }


        var users_options = {
            allowBlank:false,
            queryDelay: 0,
            triggerAction: 'all',
            resizable: true,
            mode: 'local',
            anchor:'100%',
            minChars: 1,
            fieldLabel: t("Allowed users"),
            emptyText: t("Choose Users"),
            name: 'allowed_users',
            value: user_value,
            store:users_store,
            displayField: 'value',
            valueField: 'id',
            forceFormValue: true
        };

        this.users = new Ext.ux.form.SuperBoxSelect(users_options);


        var roles_store =new Ext.data.ArrayStore({
            sortInfo: { field: "value", direction: "ASC" },
            fields: [
                {name: "key", type: "int"},
                {name: "value", type: "string"}
            ]
        });

        var roles_options = node.objectinputrestriction_data["roles"]
        for (var i = 0; i < roles_options.length; i++) {
            var record = new roles_store.recordType({id: roles_options[i].id, value: roles_options[i].value});
            roles_store.add(record);
        }


        var roles_options = {
            allowBlank:false,
            queryDelay: 0,
            triggerAction: 'all',
            resizable: true,
            mode: 'local',
            anchor:'100%',
            minChars: 1,
            fieldLabel: t("Allowed roles"),
            emptyText: t("Choose Roles"),
            name: 'allowed_roles',
            value: roles_value,
            store: roles_store,
            displayField: 'value',
            valueField: 'id',
            forceFormValue: true
        };


        this.users = new Ext.ux.form.SuperBoxSelect(users_options);
        this.roles = new Ext.ux.form.SuperBoxSelect(roles_options);



        this.layout.add({
            xtype: "form",
            title: t("Access restrictions"),
            bodyStyle: "padding: 10px;",
            style: "margin: 10px 0 10px 0",

            items: [
                this.users,
                this.roles
            ]

        });



        return this.layout;
    }
};
