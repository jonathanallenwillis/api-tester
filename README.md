

# Web API tester

Given a description of a web API in terms of expectations, check each one and show failing expectations.


## Sample expectation

```
{
    "type": "json",
    "expectations": [
        {
            "uri": "\/date",
            "expected": "\/[0-9]{4}-[0-9]{2}-[0-9]{2}\/"
        }
    ],
    "base_uri": "http://www.example.com"
}
```

It will fetch http://www.example.com/date and ensure it's JSON and that the regex matches.

