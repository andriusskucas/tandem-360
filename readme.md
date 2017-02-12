# Tandem 360 plugin for wordpress
This is the plugin for displaying 360 object slider in wordpress.
## How to use:
- Put this repository contents to your wordpress plugins folder
- Go to "plugins" page in your wordpress admin
- Install "360 objektų galerijos" plugin
- After instalation you will see new menu item "360 objektai"
- #### Add new 360 object:
    - Go to "360 objektai" menu item in admin page.
    - Press "Pridėti naują".
    - Input frames count ("Kadrų skaičius") depending on how many photos there will be in a sequence.
    - Press "Pasirinkti nuotraukas" to add all the photos. You can all the photos at once.
    - Press "publish" to save.
    - After saving you will be able to add hotspots.
- #### Add hotspots:
    - To enable hotspots tick "Įjungti aktyvius taškus" checkbox.
    - "Plokštumos kampas" - is a field to determine the angle at witch the photos were taken. Usually it is araund -9 -10 degrees. But could be anything it is basically trial and error thing to find it for every object.
    - "Aktyvių taškų kodas" - is a field where you will be able to see all hotspots code. It is used when you need to export hotspots from one object to another.
    - To add new hotspot press "+ Pridėti aktyvų tašką".
    - A new hotspot pop-up will open.
        - You can enter title and description for a hotspot. You can also style your description as you want but don't get crazy with it.
        - X, Y and Z position is set in a range from -100 to 100 precent. Where X: -100 is on top most left side of the first frame (Just play with it).
        - Also you can check all the check boxes in which frames you want to show the hotspot, because there is no other way to determine whe the hotspot is in front of the object and when it is behind it.
        - Also to create different style of hotspots you can add custom css class to it.
        - When you finish you can press "Pridėti"
        - And don't forget to save.
    - To add you object to any page copy object shortcode (Which looks something like this: [tandem-360 id="1"]) and paste it in any page or post or use wordpress built in function for displaying shortcodes in code.

## To develop:
- First you need to install node js (https://nodejs.org/en/).
- The you have to install SASS into your machine (http://sass-lang.com/install).
- Clone this repository to your machine.
- Go to plugin directory.
- Open terminal and run "npm install"
- After finishing instalation run "gulp watch" to start watching for changes.
- All the source files are in the assets folder.