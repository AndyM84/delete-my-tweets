Delete-My-Tweets
================
The 'Delete-My-Tweets' project is a basic script to help users delete past tweets via the Twitter API.

It requires PHP v8 or higher configured with the CURL extension.  Once downloaded, simply run the following commands to get started:

```
composer update
php deleter.php
```

At this point the script will create a new `settings.json` file with default access values for Twitter.  Replace those values with valid tokens/secrets from an app you have registered with Twitter, and you will be able to run the script:

```
php deleter.php
php deleter.php --file myTweetIds.txt
```

ID File Format
--------------
The script expects a plain text file with a single tweet ID on each line, such as this:

```text
1588566542694092801
1588421721799131136
1588421442059702272
```

The default file name is `tweetIds.txt` and can be changed using the `-f|--file` option when running the script.