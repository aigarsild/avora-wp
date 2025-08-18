#!/bin/bash

# AVORA Projects Sync Script
# This script creates the exact same projects on the server as defined locally

echo "🚀 Starting AVORA Projects Sync to Server..."

# Server connection details
SERVER="virt139545@sn-69-6.tll07.zoneas.eu"
SERVER_PATH="~/domeenid/www.avora.ee"

echo "📋 Creating projects on server..."

# SSH to server and run the project creation commands
ssh $SERVER << 'ENDSSH'
cd ~/domeenid/www.avora.ee

echo "🗑️  Cleaning up existing projects..."
# Remove existing projects to start fresh
wp post delete $(wp post list --post_type=project --field=ID) --force

echo "🏢 Creating Seaside Residence project..."
# Create Seaside Residence
SEASIDE_ID=$(wp post create --post_type=project --post_title='Seaside Residence' --post_name='seaside-residence' --post_status=publish --porcelain --post_content='Kaasaegne korterelamu kompleks mere ääres, mis pakub elanikele suurepäraseid vaadeteid ja luksuslikku elukeskkonda. Hoone arhitektuur ühendab endas modernset disaini ja funktsionaalsust.

Igal korteril on oma rõdu või terrass, kust avaneb vaade merele või linna panoraamile. Hoones on kaasaegne ventilatsiooni- ja küttesüsteem, mis tagab optimaalse mikroklima aastaringselt.

Kompleks asub vaid mõne sammukese kaugusel merest ja pakkub elanikele täielikku privaatsust ning rahu. Hoone ümbritseb hoolega planeeritud haljasala, mis loob rahulikku atmosfääri.

Kõik korterid on varustatud kvaliteetsete materjalide ja seadmetega. Hoones on ka ühisruumid, sealhulgas fitness-keskus ja saunakompleks.')

# Set excerpt
wp post meta set $SEASIDE_ID _excerpt "Kaasaegne korterelamu mere ääres. Luksuslikud korterid suurepäraste vaadetega ja tänapäevaste mugavustega."

# Set Seaside metadata
wp post meta set $SEASIDE_ID project_status "Ehituses"
wp post meta set $SEASIDE_ID project_location "Tallinn, Pirita"
wp post meta set $SEASIDE_ID project_year "2024"
wp post meta set $SEASIDE_ID project_type "Korterimaja"
wp post meta set $SEASIDE_ID project_units "24 korterit"
wp post meta set $SEASIDE_ID project_area "3,200 m²"

echo "🏙️  Creating Urban Loft Tallinn project..."
# Create Urban Loft Tallinn
URBAN_ID=$(wp post create --post_type=project --post_title='Urban Loft Tallinn' --post_name='urban-loft-tallinn' --post_status=publish --porcelain --post_content='Innovatiivne loft-stiilis eluhoone Tallinna südames, mis ühendab industriaalse disaini kaasaegsete mugavustega. Hoone on rekonstrueeritud endisest tehasehoones, säilitades selle autentse charmi ja lisades tänapäevaseid elemente.

Iga loft on unikaalne avatud planeeringuga ruum, kus kõrged laed ja suured aknad loovad avarad ja valgusrikkad eluruumid. Säilinud on algsed tellistseinad ja metallikonstruktsioonid, mis annavad ruumidele erilise iseloomu.

Hoones on modernne infrastruktuur, sealhulgas lift, turvasüsteem ja kiire internetiühendus. Loftide asukoht linna keskuses võimaldab mugavat juurdepääsu kõigile teenustele ja kultuuriasutustele.

Ideaalne valik noortele professionaalidele ja kunstiinimestele, kes hindavad eripärast arhitektuuri ja urbaanse elukeskkonna eeliseid.')

# Set excerpt
wp post meta set $URBAN_ID _excerpt "Unikaalsed loft-korterid rekonstrueeritud tehasehoones Tallinna kesklinnas. Industriaalne disain kohtub kaasaegsete mugavustega."

# Set Urban Loft metadata
wp post meta set $URBAN_ID project_status "Planeerimisel"
wp post meta set $URBAN_ID project_location "Tallinn, Kesklinn"
wp post meta set $URBAN_ID project_year "2025"
wp post meta set $URBAN_ID project_type "Loft-korterid"
wp post meta set $URBAN_ID project_units "18 lofti"
wp post meta set $URBAN_ID project_area "2,800 m²"

echo "🌲 Creating Forest Retreat Resort project..."
# Create Forest Retreat Resort
FOREST_ID=$(wp post create --post_type=project --post_title='Forest Retreat Resort' --post_name='forest-retreat-resort' --post_status=publish --porcelain --post_content='Eksklusiivne spa- ja puhkekeskus Eesti looduskauni metsa südames, mis pakub täielikku rahu ja ühendust loodusega. Resort koosneb luksuslikest puhkemajakestest ja keskushoonetest, mis on ehitatud keskkonnasõbralikke materjale kasutades.

Iga puhkemajake on unikaalselt disainitud, pakkudes panoraamvaadet ümbritsevale metsale. Hooned on projekteeritud minimaalselt mõjutama looduskeskkonda, kasutades geotermaalset kütet ja päikeseenergia lahendusi.

Resordis on täisteenindusega spa-keskus, restoran kohaliku köögiga, konverentsisaalid ja mitmesugused tegevused nagu matkaraja, veesõidukite rent ja loodusgiidiga ekskursioonid.

Ideaalne sihtkoht äriürituste, pulmade või lihtsalt kvaliteetse puhkuse veetmiseks keset Eesti kauneid metsi. Resort pakub kõrgetasemelist teenindust ja privaatsust.')

# Set excerpt
wp post meta set $FOREST_ID _excerpt "Luksuslik spa- ja puhkekeskus Eesti metsade südames. Keskkonnasõbralik arhitektuur ja täisteenindusega resort."

# Set Forest Retreat metadata
wp post meta set $FOREST_ID project_status "Müügis"
wp post meta set $FOREST_ID project_location "Harjumaa, Kõrvemaa"
wp post meta set $FOREST_ID project_year "2024"
wp post meta set $FOREST_ID project_type "Puhkekeskus"
wp post meta set $FOREST_ID project_units "12 maja + keskus"
wp post meta set $FOREST_ID project_area "15,000 m²"



echo "✅ Projects created successfully!"
echo "📊 Summary:"
echo "- Seaside Residence (ID: $SEASIDE_ID)"
echo "- Urban Loft Tallinn (ID: $URBAN_ID)"  
echo "- Forest Retreat Resort (ID: $FOREST_ID)"

# List all projects
echo "📋 All projects:"
wp post list --post_type=project --fields=ID,post_title,post_status
ENDSSH

echo "🎉 Projects sync completed!"
echo "🌐 Visit your website: https://avora.ee"
echo "📋 Check projects page: https://avora.ee/projektid"

