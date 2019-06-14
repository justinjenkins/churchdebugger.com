# Welcome to the Church Debugger

This is a placeholder for fun little project for me, Justin Jenkins.

### VerseSee

Verse See is bot that will respond to a word sent to it with an image with a Bible verse super imposed over it.

![](https://github.com/justinjenkins/churchdebugger.com/blob/develop/app/public/example.jpg?raw=true)



##### How does it work?

You can use versesee via a text message or via twitter. For example, you can text your word to the number provided and within a minute it will text you back a dynamic image just for you!

To do this we use the following APIs:

**Unsplash**

Unsplash is a website/service that provides free images and a pretty great API. We use unsplash to get an image that is related to the word you've sent versesee. It's not always perfect of course, but the fun part is we get a *random image* at the time of your request so it'll often be something new each time!

**Twilio**

Twilio provides an API to receive and send text messages (it actually does a lot more, but let's not get distracted) ... we use their API to both direct your text message to the versesee network but also send a text/image back to your phone.

**Twitter**

If you chose Twitter instead of text we use their API to look up mentions of @versesee every minute and respond back with an image.

**ESV Bible API**

We use the ESV Bible API to look up a verse based on the word you sent versesee. Again, it's not always perfect but just like with the image the bot chooses the verse is *randomly chosen* each time so it is always fun.

**ImageMagick**

To resize the image and place the text over the top with a shadow versesee uses ImageMagick a powerful image manipulation/creation library.

**Laravel**

To do all this versesee uses the PHP framework Laravel under the covers. We're using a number of Laravel's features here including (but not limited to):

- Service Providers
- Jobs
- Console Commands
- Events
- Listeners
- Laravel Cron

**AWS**

VerseSee is hosted on AWS (Amazon Web Services), using a `t2.medium` instance, which is why it's a *little* slow to generate images sometimes. If this were a real, production server it'd be a lot faster.