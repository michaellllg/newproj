<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .container {
  text-align: center;

  background-color: #f2f2f2;
  padding: 30px;
  border: .1px solid white ;
  border-radius: 10px;
  box-shadow: 0 0 25px rgba(0, 0, 0, .1);
  width: 500px !important;
  margin: right;
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


</style>
<body>
<?php include('nav.php'); ?>


<div class="container">
    <h1>Daily Bible Verse</h1>
    <div id="verse-container">
      <p id="bible-verse"></p>
      <p id="reference"></p>
    </div>
</div>

<script>
        const verses = [
  { text: "For I know the plans I have for you, declares the Lord, plans for welfare and not for evil, to give you a future and a hope.", reference: "Jeremiah 29:11" },
  { text: "The Lord is my shepherd; I shall not want.", reference: "Psalm 23:1" },
  { text: "I can do all things through him who strengthens me.", reference: "Philippians 4:13" },
  { text: "For God so loved the world, that he gave his only Son, that whoever believes in him should not perish but have eternal life.", reference: "John 3:16" },
  { text: "The Lord is near to the brokenhearted and saves the crushed in spirit.", reference: "Psalm 34:18" },
  { text: "But the fruit of the Spirit is love, joy, peace, forbearance, kindness, goodness, faithfulness, gentleness and self-control.", reference: "Galatians 5:22-23" },
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