const regex = /(^\w+.*)|(^\s{21,}.+[A-Z0-9])|(^\s{5,}.+)/gm;
const str = ` LEGO DCSHG "Galactic Wonder" Animatic 3 (6/21/16)     4.


WW is doing fine, but then sees her mother STARING at her 
from the audience and gets nervous.

Katana STRIKES. She's won this round! Wonder Woman SMILES.

                    WONDER WOMAN SUPER
          Good match, Katana.

Wonder Woman STANDS and finds Hippolyta next to her.

                    HIPPOLYTA
          Has this "school" so dulled your 
          keen edge that you would lose to 
          this low-born commoner?

                    WONDER WOMAN
          Mother, some of the finest
          swordswomen in the world are "low- 
          born" and "common."

WIDEN TO INCLUDE KATANA.

                    KATANA
          And I'm standing right here.


INT. HEROBALL GAME - CONTINUOUS

In a demo game, Bumblebee, Batgirl, Supergirl and WW are 
playing against FLASH, GREEN LANTERN, CYBORG and HARLEY! We 
see dummies labelled "CITIZEN," "POLICEMAN" and "FIREMAN."

WW looks nervously at her mother on the sidelines. The match##
begins and Harley dashes across the field with a citizen.   ##
Wonder Woman used her lasso to rope Harley and steals the   ##
citizen from her hands.                                     ##

                    HARLEY QUINN                            ##
          [impact grunt]                                    ##

Wonder Woman runs toward the net getting the citizen to     ##
saftey.                                                     ##

                    BUMBLEBEE                               ##
          Yay, Wonder Woman! You tied it up!

Wonder Woman's SMILE soon FADES as she GLANCES at her 
unflinching mother.

A citizen POPS OUT and WW, self-conscious and distracted, 
TRIPS on it!

                    WONDER WOMAN 
          <falling cry>
`;
let m;
var matches = [];

while ((m = regex.exec(str)) !== null) {
    // This is necessary to avoid infinite loops with zero-width matches
    if (m.index === regex.lastIndex) {
        regex.lastIndex++;
    }
    
    // The result can be accessed through the `m`-variable.
    m.forEach((match, groupIndex) => {
        comment = m.match[0];
        name = m.match[1];
        dialogue = m.match[2];
        // console.log(`Found match, group ${groupIndex}: ${match}`);
        matches.push({comment, name, dialogue})
        console.log("matches ", matches )
    });
}

// (^\w+.*)|(^\s{21,}.+[A-Z0-9])|(^\s{5,}.+)