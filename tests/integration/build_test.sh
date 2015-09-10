#!/usr/bin/env bash
__FILE__=$(readlink -f $0)
__DIR__=$(dirname $__FILE__)
RED='\033[0;31m'
GREEN='\033[0;32m'
NORMAL='\033[0m'

PHAR=${__DIR__}/../../build/api-tester.phar
CMD="php $PHAR api:test"

fail() {
    echo -e "[${RED}FAILED${NORMAL}] $@"
}
pass() {
    echo -e "[${GREEN}PASSED${NORMAL}] $@"
}
test_has_been_built() {
    [ -f "$PHAR" ]
}

test_is_silent_on_success() {
    local source=${__DIR__}/../unit/fixtures/definition.json
    [ -z "$($CMD $source 2>&1)" ]
}

test_stderr_on_bad_data() {
    local source=${__DIR__}/../unit/fixtures/definition_invalid.json
    [ ! -z "$($CMD $source 2>&1 | grep "Failed asserting data" )" ]
}

run_tests() {

    local has_error, tests
    has_error=0;

    tests=$(declare -f | grep -P '^test_'  | cut -d' ' -f 1)
    while read test_fn; do
        if $test_fn ; then
            pass $test_fn
        else
            fail $test_fn
            has_error=1
        fi
    done <<< "$tests"

    exit $has_error
}

run_tests