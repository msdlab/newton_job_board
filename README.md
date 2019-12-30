# newton_job_board
Simple Wordpress plugin to add a Newton Jobs Board to your site. Must have Newton account set up to use.
In the past week, we’ve received two requests from clients trying to display their Newton Job Board on their WordPress website. Newton provides a user-friendly, mobile ready, fully-featured applicant tracking system for small and medium-sized employers. In addition, it allows its clients to display their available positions on their own website with a single line of javascript code. Pretty cool, huh?

Only one small problem. For security reasons, WordPress generally strips out javascript code added through the editor interface. There are a number of plugins that will override this setting, but we tend to not be fans, as they can open additional security holes as well. So we crafted up a quick and dirty plugin to add the javascript with a simple shortcode.

It’s pretty self explanatory, and really only does one thing: adds a shortcode that will display your job board. Just activate, add the “clientID” from the javascript that Newton provided you to the Newton Job Board settings, and add the shortcode [newton-job-board] (also available through a editor button) to your page. Of course, you will have to have the appropriate settings on your Newton dashboard as well.

I hope someone finds this useful.
- See more at: http://msdlab.com/blog/newton-software-job-board/#sthash.bWZyatcn.dpuf
