(function (global, factory) {

    "use strict";

    if (typeof module === "object" && typeof module.exports === "object") {

        module.exports = global.document
            ? factory(global, true)
            : function (w) {
                if (!w.document) {
                    throw new Error("Front-stack requires a window with a document");
                }
                return factory(w);
            };
    } else {
        factory(global);
    }

})(typeof window !== "undefined"
    ? window
    : this, function (window) {

    /**
     * Singletone instance.
     *
     * @type {FrontStack|null}
     */
    var instance = null;

    // Object name which use extracting any variables passed from backend.
    var stack_name = 'backend';

    /**
     * Made recursive get of array with dot notation.
     *
     * @param {Object} data Search data
     * @param {string} key Key with dot notation ex. "a.b.c"
     * @param {*} default_value value that must be returned.
     *
     * @returns {*}
     */
    var recursive_get = function (data, key, default_value) {
        if (data.hasOwnProperty(key)) {
            return data[key];
        }

        var key_arr = key.toString().split('.');

        var next_key = key_arr.shift();

        if (!data.hasOwnProperty(next_key)) {
            return (typeof default_value !== 'undefined')
                ? default_value
                : null;
        }

        return recursive_get(data[next_key], key_arr.join('.'), default_value);
    };

    /**
     * StackFront object (as singletone).
     *
     * @returns {FrontStack}
     */
    var FrontStack = function () {

        /**
         * Method get params form backend.
         *
         * params {name, default_value} String
         * @returns {object}
         */
        this.get = function (name, default_value) {
            var value = recursive_get(this.all(), name, default_value);
            if (value) {
                return value;
            }

            return (typeof default_value !== 'undefined')
                ? default_value
                : null;
        };

        /**
         * Method check function on existence.
         *
         * @params {name} String
         * @returns {boolean}
         */
        this.has = function (name) {
            var value = recursive_get(this.all(), name, default_value);
            if (value) {
                return true;
            }

            return false;
        };

        /**
         * Method return all stack data as object.
         *
         * @returns {Object}
         */
        this.all = function () {
            if (window.hasOwnProperty(stack_name)) {
                var stack = window[stack_name];

                if (typeof stack === 'object') {
                    return stack;
                }
            }

            return {};
        };

        // Check instance exists
        if (instance !== null) {
            throw new Error('Cannot instantiate more than one instance, use .getInstance()');
        }
    };

    /**
     * Returns FrontStack object instance.
     *
     * @returns {null|FrontStack}
     */
    FrontStack.__proto__.getInstance = function () {
        if (instance === null) {
            instance = new FrontStack();
        }
        return instance;
    };

    window.frontStack = FrontStack.getInstance();

    return window.frontStack;
});
