# Welcome to the Church Debugger

This is a placeholder for fun little projects by me, [Justin Jenkins](<https://www.linkedin.com/in/thejustinjenkins/>).

### VerseSee

VerseSee is bot that will respond to a word sent to it with an image with a Bible verse super imposed over it.

![](https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example.jpg?raw=true)

<img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-3.jpg?raw=true" width="217"> <img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-1.jpg?raw=true" width="217"> <img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-4.jpg?raw=true" width="217"> <img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-2.jpg?raw=true" width="217">

<img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-7.jpg?raw=true" width="217"> <img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-5.jpg?raw=true" width="217"> <img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-8.jpg?raw=true" width="217"> <img src="https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/examples/example-6.jpg?raw=true" width="217"> 

##### How does it work?

You can use VerseSee via a text message or via twitter. For example, you can text your word to the number provided and within a minute it will text you back a dynamic image just for you!

To do this we use the following APIs:

**Unsplash**

Unsplash is a website/service that provides free images and a [pretty great API](<https://unsplash.com/developers>). We use unsplash to get an image that is related to the word you've sent VerseSee . It's not always perfect of course, but the fun part is we get a *random image* at the time of your request so it'll often be something new each time!

**Twilio**

Twilio provides an [API](https://www.twilio.com/docs/usage/api) to receive and send text messages (it actually does a lot more, but let's not get distracted) ... we use their API to both direct your text message to the VerseSee network but also send a text/image back to your phone.

**Twitter**

If you chose Twitter instead of text we use their [API](https://developer.twitter.com/en/docs/tweets/search/overview) to look up mentions of [@versesee](https://twitter.com/versesee) every minute and respond back with an image.

**ESV Bible API**

We use the ESV Bible [API](https://api.esv.org/docs/passage-search/) to look up a verse based on the word you sent VerseSee . Again, it's not always perfect but just like with the image the bot chooses the verse is *randomly chosen* each time so it is always fun.

**ImageMagick**

To resize the image and place the text over the top with a shadow VerseSee uses [ImageMagick](https://www.php.net/manual/en/book.imagick.php) a powerful image manipulation/creation library.

**Laravel**

To do all this VerseSee uses the PHP framework [Laravel](https://laravel.com/) under the covers. We're using a number of Laravel's features here including (but not limited to):

- Service Providers
- Jobs
- Console Commands
- Events
- Listeners
- Laravel Cron

**AWS**

VerseSee is hosted on AWS (Amazon Web Services), using a `t2.medium` instance, which is why it's a *little* slow to generate images sometimes. If this were a real, production server it'd be a lot faster.