/**
 * Tests for front-stack.js functional.
 */
var window = {document: {}};
window.frontStack = require('../src/assets/front-stack.js');

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

test('window.frontStack', function () {
    expect(typeof window.frontStack).toBe('object');
});


test('');
