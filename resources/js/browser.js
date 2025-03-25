const puppeteer = require('puppeteer');

(async () => {
    const url = process.argv[2]; // Ambil URL dari parameter
    const browser = await puppeteer.launch({ headless: true });
    const page = await browser.newPage();

    await page.goto(url, { waitUntil: 'networkidle2' });

    // Ambil URL video dari iframe atau sumber lain
    const videoUrl = await page.evaluate(() => {
        const iframe = document.querySelector('iframe');
        return iframe ? iframe.src : null;
    });

    console.log(videoUrl);
    await browser.close();
})();
