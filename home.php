<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home Page</title>
</head>

<style>
 body {
        margin: 0;
        padding: 0;
        background-image: url('images/bg-myatt.png'); /* Use your file path */
        background-size: cover; /* Ensures the image covers the entire screen */
        background-position: center; /* Centers the image */
        background-repeat: no-repeat; /* Prevents the image from repeating */
        background-attachment: fixed; /* Keeps the image fixed during scrolling */
        font-family: Arial, sans-serif; /* Apply a clean font style */
    }
    
  .container {
  text-align: center;
  background-color: #f2f2f2;
  padding: 50px;
  border: 5px solid #0f3e84; ;
  border-radius: 10px;
  box-shadow: 0 0 25px rgba(0, 0, 0, .1);
  width: 550px !important;
  margin: right;
  margin-top: 5px; /* Adjust this value to move it lower */
  position: relative;
  top: 30px;
}

#bible-verse {
  font-size: 1.2em;
  margin: 20px 0;
}

#reference {
  font-style: italic;
  color: #888;
}


/* Welcome section */
.welcome-section {
    text-align: left;
    padding: 50px 20px;
    margin: 0 auto;
    margin-left: 10px;
    max-width: 800px;
    background-color: white;
}

.welcome-section h1 {
    color: #0f3e84;
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.welcome-section p {
    font-size: 1rem;
    color: #666;
}


</style>
<body>
<?php include('nav.php'); ?>
<div class="welcome-section">
            <h1>Hello, User 123!</h1>
            <p>Here is your daily verse to keep you motivated.</p>
        </div>
<div class="container">
    <h1>Daily Bible Verse</h1>
    <div id="verse-container">
      <p id="bible-verse"></p>
      <p id="reference"></p>
    </div>
</div>


<script>
        const verses = [
          { text: "Therefore, if anyone is in Christ, he is a new creation; the old has gone, the new has come!", reference: "2 Corinthians 5:17" },
          { text: "For I know the plans I have for you, declares the Lord, plans to prosper you and not to harm you, plans to give you hope and a future.", reference: "Jeremiah 29:11" },
          { text: "I can do all things through Christ who strengthens me.", reference: "Philippians 4:13" },
          { text: "The Lord is my shepherd; I shall not want.", reference: "Psalm 23:1" },
          { text: "But those who hope in the Lord will renew their strength. They will soar on wings like eagles; they will run and not grow weary, they will walk and not be faint.", reference: "Isaiah 40:31" },
          { text: "And we know that in all things God works for the good of those who love Him, who have been called according to His purpose.", reference: "Romans 8:28" },
          { text: "Trust in the Lord with all your heart and lean not on your own understanding; in all your ways submit to Him, and He will make your paths straight.", reference: "Proverbs 3:5-6" },
          { text: "Be strong and courageous. Do not be afraid; do not be discouraged, for the Lord your God will be with you wherever you go.", reference: "Joshua 1:9" },
          { text: "Jesus answered, I am the way and the truth and the life. No one comes to the Father except through me.", reference: "John 14:6" },
          { text: "Cast all your anxiety on Him because He cares for you.", reference: "1 Peter 5:7" },
          { text: "Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.", reference: "Philippians 4:6" },
          { text: "The Lord is near to the brokenhearted and saves the crushed in spirit.", reference: "Psalm 34:18" },
          { text: "Rejoice always, pray without ceasing, give thanks in all circumstances; for this is the will of God in Christ Jesus for you.", reference: "1 Thessalonians 5:16-18" },
          { text: "The steadfast love of the Lord never ceases; His mercies never come to an end; they are new every morning; great is Your faithfulness.", reference: "Lamentations 3:22-23" },
          { text: "The fear of the Lord is the beginning of knowledge; fools despise wisdom and instruction.", reference: "Proverbs 1:7" }, 
          { text: "Finally, be strong in the Lord and in the strength of His might.", reference: "Ephesians 6:10" },
          { text: "Your word is a lamp to my feet and a light to my path.", reference: "Psalm 119:105" },
          { text: "He heals the brokenhearted and binds up their wounds.", reference: "Psalm 147:3" },
          { text: "For it is by grace you have been saved, through faith—and this is not from yourselves, it is the gift of God.", reference: "Ephesians 2:8" },
          { text: "Come to me, all who labor and are heavy laden, and I will give you rest.", reference: "Matthew 11:28" },
          { text: "Even though I walk through the valley of the shadow of death, I will fear no evil, for You are with me; Your rod and Your staff, they comfort me.", reference: "Psalm 23:4" },
          { text: "Delight yourself in the Lord, and He will give you the desires of your heart.", reference: "Psalm 37:4" },
          { text: "Therefore do not worry about tomorrow, for tomorrow will worry about itself. Each day has enough trouble of its own.", reference: "Matthew 6:34" },
          { text: "For where two or three gather in my name, there am I with them.", reference: "Matthew 18:20" },
          { text: "Be still, and know that I am God.", reference: "Psalm 46:10" },
          { text: "I have told you these things, so that in me you may have peace. In this world you will have trouble. But take heart! I have overcome the world.", reference: "John 16:33" },
          { text: "So faith comes from hearing, and hearing through the word of Christ.", reference: "Romans 10:17" },
          { text: "If we confess our sins, He is faithful and just to forgive us our sins and to cleanse us from all unrighteousness.", reference: "1 John 1:9" },
          { text: "Let the peace of Christ rule in your hearts, since as members of one body you were called to peace. And be thankful.", reference: "Colossians 3:15" },
          { text: "Blessed are the pure in heart, for they shall see God.", reference: "Matthew 5:8" },
          { text: "But seek first the kingdom of God and His righteousness, and all these things will be added to you.", reference: "Matthew 6:33" },
          { text: "Create in me a clean heart, O God, and renew a right spirit within me.", reference: "Psalm 51:10" },
          { text: "We love because He first loved us.", reference: "1 John 4:19" },
          { text: "Above all, love each other deeply, because love covers over a multitude of sins.", reference: "1 Peter 4:8" },
          { text: "Be kind and compassionate to one another, forgiving each other, just as in Christ God forgave you.", reference: "Ephesians 4:32" },
          { text: "The Lord is my light and my salvation; whom shall I fear? The Lord is the stronghold of my life; of whom shall I be afraid?", reference: "Psalm 27:1" },
          { text: "Therefore encourage one another and build each other up, just as in fact you are doing.", reference: "1 Thessalonians 5:11" },
          { text: "And my God will meet all your needs according to the riches of His glory in Christ Jesus.", reference: "Philippians 4:19" },
          { text: "For the word of God is alive and active. Sharper than any double-edged sword, it penetrates even to dividing soul and spirit, joints and marrow; it judges the thoughts and attitudes of the heart.", reference: "Hebrews 4:12" },
          { text: "But God shows His love for us in that while we were still sinners, Christ died for us.", reference: "Romans 5:8" },
          { text: "Do everything in love.", reference: "1 Corinthians 16:14" },
          { text: "Let us not become weary in doing good, for at the proper time we will reap a harvest if we do not give up.", reference: "Galatians 6:9" },
          { text: "You will keep in perfect peace those whose minds are steadfast, because they trust in You.", reference: "Isaiah 26:3" },
          { text: "For God gave us a spirit not of fear but of power and love and self-control.", reference: "2 Timothy 1:7" },
          { text: "He must increase, but I must decrease.", reference: "John 3:30" },
          { text: "This is the day that the Lord has made; let us rejoice and be glad in it.", reference: "Psalm 118:24" },
          { text: "In the beginning was the Word, and the Word was with God, and the Word was God.", reference: "John 1:1" },
          { text: "The Lord bless you and keep you; the Lord make His face shine on you and be gracious to you; the Lord turn His face toward you and give you peace.", reference: "Numbers 6:24-26" },
          { text: "Come near to God and He will come near to you.", reference: "James 4:8" },

  // Add more verses as needed
];

// Get today's date and use it as an index for the verses array
function getDailyVerse() {
  const today = new Date();
  const dayOfYear = Math.floor((today - new Date(today.getFullYear(), 0, 0)) / 86400000);
  const verseOfTheDay = verses[dayOfYear % verses.length];

  document.getElementById('bible-verse').textContent = `"${verseOfTheDay.text}"`;
  document.getElementById('reference').textContent = `- ${verseOfTheDay.reference}`;
}

// Load the verse when the page is loaded
window.onload = getDailyVerse;


    </script>
</body>
</html>