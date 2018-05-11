pimcore.registerNS("pimcore.plugin.ExteraFormBuilderToDbBundle");

pimcore.plugin.ExteraFormBuilderToDbBundle = Class.create(pimcore.plugin.admin, {
    getClassName: function () {
        return "pimcore.plugin.ExteraFormBuilderToDbBundle";
    },

    initialize: function () {
        pimcore.plugin.broker.registerPlugin(this);
    },

    pimcoreReady: function (params, broker) {
        // alert("ExteraFormBuilderToDbBundle ready!");
    }
});

var ExteraFormBuilderToDbBundlePlugin = new pimcore.plugin.ExteraFormBuilderToDbBundle();
