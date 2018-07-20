/**
 * Tests for front-stack.js functional.
 */

/**
 * Test init object for work with backend data.
 */
var testInitObject = function () {

    QUnit.module('Initialization');

    QUnit.test('window.frontStack', function (assert) {
        assert.ok(typeof window.frontStack === 'object', 'Check the front-stack access object exists');
    });
};

/**
 * Test object for work with backend data.
 */
var testWorkObject = function () {

    /**
     * Object name that use extracting any variables passed from backend.
     *
     * @type {string}
     */
    var stack_name = 'backend';

    /**
     * Keys that are in the data
     *
     * @type {[string,string,string,string,string,string,string,string]}
     */
    var exists_test_keys = [
        'test_string_key',
        'test_key_for_num_val',
        'test_object_key',
        'test_null_key',
        'test_object_key.0',
        'test_object_key.3.test_array',
        'test_object_key.3.test_array.0',
        'test_object_key.test_4',
        88
    ];

    /**
     * Keys that are not in the data
     *
     * @type {[string,string,string,string]}
     */
    var not_exists_test_keys = [
        'not_exists_key',
        '0',
        '0.0',
        'test_object_key.0.not_exists',
        0,
        ''
    ];

    /**
     * Setup module init.
     */
    QUnit.module('Data access', {

        /**
         * Setup test-data.
         */
        before: function () {
            Object.defineProperty(window, stack_name, {
                writable: true,
                value: {
                    'test_string_key': 'test_value',
                    'test_key_for_num_val': 1000,
                    88: 123,
                    'test_object_key': {
                        0: 10,
                        1: 11,
                        3: {
                            'test_array': [1, 'array_val', null]
                        },
                        'test_4': 'value_4'
                    },
                    'test_null_key': null
                }
            });
        }
    });

    /**
     * Tests getting all data by data-access object.
     */
    QUnit.test('all()', function (assert) {

        var all_data = window.frontStack.all();

        assert.ok(typeof all_data === 'object', 'Check "all()" method');

        // 0 => Actual, 1 =>Expecte, 2 => Message
        var test_data = [
            [all_data.test_string_key, 'test_value', 'Check string value'],
            [all_data.test_key_for_num_val, 1000, 'Check numeric value'],
            [all_data[88], 123, 'Check numeric value'],
            [all_data.test_null_key, null, 'Check null value']
        ];

        test_data.forEach(function(test_item) {
            assert.strictEqual(test_item[0], test_item[1], test_item[2]);
        });

        assert.deepEqual(all_data.test_object_key, window[stack_name].test_object_key, 'Check value which is an object');
    });

    /**
     * Tests checking data exists.
     */
    QUnit.test('has()', function (assert) {
        exists_test_keys.forEach(function (test_key) {
            assert.ok(window.frontStack.has(test_key), 'Test has() for key: ' + test_key);
        });
    });

    /**
     * Tests checking data exists for not exists keys.
     */
    QUnit.test('! has()', function (assert) {
        not_exists_test_keys.forEach(function (test_key) {
            assert.notOk(window.frontStack.has(test_key), 'Test not has() for key: ' + test_key);
        });
    });

    /**
     * Tests checking data exists.
     */
    QUnit.test('get()', function (assert) {

        // 0 => Key, 1 => Expected, 2 => Message
        var test_data = [
            ['test_string_key', 'test_value', 'Test getting simple string value by string key'],
            ['test_key_for_num_val', 1000, 'Test getting simple numeric value by string key'],
            [88, 123, 'Test getting simple numeric value by numeric key'],
            ['test_null_key', null, 'Test getting null'],
            ['test_object_key.0', 10, 'Dot-notation'],
            ['test_object_key.1', 11, 'Dot-notation'],
            ['test_object_key.3.test_array.0', 1, 'Dot-notation'],
            ['test_object_key.3.test_array.1', 'array_val', 'Dot-notation'],
            ['test_object_key.3.test_array.2', null, 'Dot-notation'],
            ['test_object_key.test_4', 'value_4', 'Dot-notation']
        ];

        test_data.forEach(function(test_item) {
            assert.strictEqual(window.frontStack.get(test_item[0]), test_item[1], test_item[2]);
        });

        assert.deepEqual(window.frontStack.get('test_object_key'), window[stack_name].test_object_key, 'Test getting object');

        // Not default
        assert.strictEqual(window.frontStack.get('test_string_key', 'default'), 'test_value', 'Get actual data instead default value');
    });

    /**
     * Tests checking data not exists.
     */
    QUnit.test('! get()', function (assert) {
        not_exists_test_keys.forEach(function(key) {
            assert.strictEqual(window.frontStack.get(key), undefined, 'Get by key ' + key + ' is Undefined');
        });
    });

    /**
     * Tests default value.
     */
    QUnit.test('get() default value', function (assert) {
        not_exists_test_keys.forEach(function(key) {

            var default_value = Math.random();

            assert.strictEqual(window.frontStack.get(key, default_value), default_value, 'Default value for key ' + key);
        });
    });

};

//Start the tests
testInitObject();
testWorkObject();
