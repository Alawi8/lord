import { test, expect } from "../setup";
import { loginAsCustomer, addAddress } from "../utils/customer";
import { generateName, generateSKU, generateDescription } from "../utils/faker";

async function createSimpleProduct(page) {
    /**
     * Main product data which we will use to create the product.
     */
    const product = {
        name: generateName(),
        sku: generateSKU(),
        productNumber: generateSKU(),
        shortDescription: generateDescription(),
        description: generateDescription(),
        price: "199",
        weight: "25",
    };

    /**
     * Reaching to the create product page.
     */
    await page.goto("admin/catalog/products");
    await page.waitForSelector(
        'button.primary-button:has-text("Create Product")'
    );
    await page.getByRole("button", { name: "Create Product" }).click();

    /**
     * Opening create product form in modal.
     */
    await page.locator('select[name="type"]').selectOption("simple");
    await page.locator('select[name="attribute_family_id"]').selectOption("1");
    await page.locator('input[name="sku"]').fill(generateSKU());
    await page.getByRole("button", { name: "Save Product" }).click();

    /**
     * After creating the product, the page is redirected to the edit product page, where
     * all the details need to be filled in.
     */
    await page.waitForSelector(
        'button.primary-button:has-text("Save Product")'
    );

    /**
     * Waiting for the main form to be visible.
     */
    await page.waitForSelector('form[enctype="multipart/form-data"]');

    /**
     * General Section.
     */
    await page.locator("#product_number").fill(product.productNumber);
    await page.locator("#name").fill(product.name);

    /**
     * Description Section.
     */
    await page.fillInTinymce(
        "#short_description_ifr",
        product.shortDescription
    );
    await page.fillInTinymce("#description_ifr", product.description);

    /**
     * Meta Description Section.
     */
    await page.locator("#meta_title").fill(product.name);
    await page.locator("#meta_keywords").fill(product.name);
    await page.locator("#meta_description").fill(product.shortDescription);

    /**
     * Image Section.
     */
    // Will add images later.

    /**
     * Price Section.
     */
    await page.locator("#price").fill(product.price);

    /**
     * Shipping Section.
     */
    await page.locator("#weight").fill(product.weight);

    /**
     * Inventories Section.
     */
    await page.locator('input[name="inventories\\[1\\]"]').click();
    await page.locator('input[name="inventories\\[1\\]"]').fill("5000");

    /**
     * Categories Section.
     */
    await page
        .locator("label")
        .filter({ hasText: "Men" })
        .locator("span")
        .click();

    /**
     * Saving the product.
     */
    await page.getByRole("button", { name: "Save Product" }).click();

    return product;
}

test.describe("checkout", () => {
    test("guest should be able to checkout", async ({ lordPage }) => {
        /**
         * Login to admin panel.
         */
        const adminCredentials = {
            email: "admin@example.com",
            password: "admin123",
        };

        await lordPage.goto("admin/login");
        await lordPage.getByPlaceholder("Email Address").click();
        await lordPage
            .getByPlaceholder("Email Address")
            .fill(adminCredentials.email);
        await lordPage.getByPlaceholder("Password").click();
        await lordPage
            .getByPlaceholder("Password")
            .fill(adminCredentials.password);
        await lordPage.getByRole("button", { name: "Sign In" }).click();

        /**
         * Create simple product.
         */
        const product = await createSimpleProduct(lordPage);

        /**
         * Go to lord to buy a product.
         */
        await lordPage.goto("");
        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .getByLabel(product.name)
            .waitFor({ state: "visible" });

        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .getByLabel(product.name)
            .click();
        await lordPage.getByRole("button", { name: "Add To Cart" }).click();
        await expect(lordPage.locator("#app")).toContainText(
            "Item Added Successfully"
        );
        await lordPage.locator(".icon-cancel").first().click();
        await lordPage.getByRole("button", { name: "shoping Cart" }).click();
        await lordPage
            .getByRole("link", { name: "Continue to Checkout" })
            .click();

        /**
         * Fill Customer details.
         */
        await lordPage
            .getByPlaceholder("Company Name")
            .waitFor({ state: "visible" });
        await lordPage.getByPlaceholder("Company Name").click();
        await lordPage.getByPlaceholder("Company Name").fill("WEBKUL");
        await lordPage.getByPlaceholder("First Name").click();
        await lordPage.getByPlaceholder("First Name").fill("Demo");
        await lordPage.getByPlaceholder("First Name").press("Tab");
        await lordPage.getByPlaceholder("Last Name").fill("Demo");
        await lordPage.getByPlaceholder("Last Name").press("Tab");
        await lordPage
            .getByRole("textbox", { name: "email@example.com" })
            .press("CapsLock");
        await lordPage
            .getByRole("textbox", { name: "email@example.com" })
            .fill("Demo_ashdghsd@hjdg.sad");
        await lordPage
            .getByRole("textbox", { name: "email@example.com" })
            .press("Tab");
        await lordPage.getByPlaceholder("Street Address").fill("Demo2367");
        await lordPage.getByPlaceholder("Street Address").press("Tab");
        await lordPage
            .locator('select[name="billing\\.country"]')
            .selectOption("AI");
        await lordPage.getByPlaceholder("State").click();
        await lordPage.getByPlaceholder("State").fill("Demo");
        await lordPage.getByPlaceholder("City").click();
        await lordPage.getByPlaceholder("City").fill("Demo");
        await lordPage.getByPlaceholder("Zip/Postcode").click();
        await lordPage.getByPlaceholder("Zip/Postcode").fill("2673854");
        await lordPage.getByPlaceholder("Telephone").click();
        await lordPage.getByPlaceholder("Telephone").fill("9023723564");
        await lordPage.getByRole("button", { name: "Proceed" }).click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose shipping method.
         */
        await lordPage.waitForSelector("text=Free Shipping");
        await lordPage.getByText("Free Shipping").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose payment option.
         */
        await lordPage.waitForSelector("text=Cash On Delivery");
        await lordPage.getByText("Cash On Delivery").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Place order.
         */
        await lordPage.getByRole("button", { name: "Place Order" }).click();
        await lordPage.waitForTimeout(2000);
        await lordPage.waitForSelector("text=Thank you for your order!");
        await expect(
            lordPage.locator("text=Thank you for your order!")
        ).toBeVisible();

        /**
         * Check order to admin side.
         */
        await lordPage.goto("admin/sales/orders");
        await lordPage.locator(".row > div:nth-child(4) > a").first().click();
        await expect(
            lordPage.locator(".box-shadow > div:nth-child(2) > div").first()
        ).toBeVisible();
    });

    test("customer should be able to checkout", async ({ lordPage }) => {
        /**
         * Customer login.
         */
        await loginAsCustomer(lordPage);

        /**
         * Fill customer default address.
         */
        await addAddress(lordPage);

        /**
         * Go to the lord to buy a product.
         */
        await lordPage.goto("");
        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .first()
            .waitFor({ state: "visible" });

        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .first()
            .click();
        await expect(lordPage.locator("#app")).toContainText(
            "Item Added Successfully"
        );
        await lordPage.locator(".icon-cancel").first().click();
        await lordPage.getByRole("button", { name: "shoping Cart" }).click();
        await lordPage
            .getByRole("link", { name: "Continue to Checkout" })
            .click();
        await lordPage
            .locator(
                'span[class="icon-checkout-address text-6xl text-navyBlue max-sm:text-5xl"]'
            )
            .nth(0)
            .click();
        await lordPage.getByRole("button", { name: "Proceed" }).click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose shipping method.
         */
        await lordPage.waitForSelector("text=Free Shipping");
        await lordPage.getByText("Free Shipping").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose payment option.
         */
        await lordPage.waitForSelector("text=Cash On Delivery");
        await lordPage.getByText("Cash On Delivery").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Place order.
         */
        await lordPage.getByRole("button", { name: "Place Order" }).click();
        await lordPage.waitForTimeout(2000);
        await lordPage.waitForSelector("text=Thank you for your order!");
        await expect(
            lordPage.locator("text=Thank you for your order!")
        ).toBeVisible();

        /**
         * Login to admin panel.
         */
        const adminCredentials = {
            email: "admin@example.com",
            password: "admin123",
        };
        await lordPage.goto("admin/login");
        await lordPage.getByPlaceholder("Email Address").click();
        await lordPage
            .getByPlaceholder("Email Address")
            .fill(adminCredentials.email);
        await lordPage.getByPlaceholder("Password").click();
        await lordPage
            .getByPlaceholder("Password")
            .fill(adminCredentials.password);
        await lordPage.getByRole("button", { name: "Sign In" }).click();

        /**
         * Check order to admin side.
         */
        await lordPage.goto("admin/sales/orders");
        await lordPage.locator(".row > div:nth-child(4) > a").first().click();
        await expect(
            lordPage.locator(".box-shadow > div:nth-child(2) > div").first()
        ).toBeVisible();
    });

    test("if use same address for shipping", async ({ lordPage }) => {
        /**
         * Customer login.
         */
        await loginAsCustomer(lordPage);

        /**
         * Fill customer default address.
         */
        await addAddress(lordPage);

        /**
         * Go to the lord to buy a product.
         */
        await lordPage.goto("");
        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .first()
            .waitFor({ state: "visible" });

        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .first()
            .click();
        await expect(lordPage.locator("#app")).toContainText(
            "Item Added Successfully"
        );
        await lordPage.locator(".icon-cancel").first().click();
        await lordPage.getByRole("button", { name: "shoping Cart" }).click();
        await lordPage
            .getByRole("link", { name: "Continue to Checkout" })
            .click();
        await lordPage
            .locator(
                'span[class="icon-checkout-address text-6xl text-navyBlue max-sm:text-5xl"]'
            )
            .nth(0)
            .click();

        /**
         * Enabled using same adress for shipping checkbox.
         */
        const isEnabled = lordPage.locator("#use_for_shipping").nth(1).check();

        /**
         * If not enabled, then we enable it.
         */
        if (!isEnabled) {
            const gdprsettingToggle = lordPage
                .locator("#use_for_shipping")
                .nth(1);
            await gdprsettingToggle.waitFor({
                state: "visible",
                timeout: 5000,
            });
            await lordPage.locator("#use_for_shipping").nth(1).click();
        }

        /**
         * Verifying enable state.
         */
        const toggleInput = lordPage.locator("#use_for_shipping").nth(1);
        await expect(toggleInput).toBeChecked();

        await lordPage.getByRole("button", { name: "Proceed" }).click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose shipping method.
         */
        await lordPage.waitForSelector("text=Free Shipping");
        await lordPage.getByText("Free Shipping").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose payment option.
         */
        await lordPage.waitForSelector("text=Cash On Delivery");
        await lordPage.getByText("Cash On Delivery").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Place order.
         */
        await lordPage.getByRole("button", { name: "Place Order" }).click();
        await lordPage.waitForTimeout(2000);
        await lordPage.waitForSelector("text=Thank you for your order!");
        await expect(
            lordPage.locator("text=Thank you for your order!")
        ).toBeVisible();

        /**
         * Login to admin panel.
         */
        const adminCredentials = {
            email: "admin@example.com",
            password: "admin123",
        };
        await lordPage.goto("admin/login");
        await lordPage.getByPlaceholder("Email Address").click();
        await lordPage
            .getByPlaceholder("Email Address")
            .fill(adminCredentials.email);
        await lordPage.getByPlaceholder("Password").click();
        await lordPage
            .getByPlaceholder("Password")
            .fill(adminCredentials.password);
        await lordPage.getByRole("button", { name: "Sign In" }).click();

        /**
         * Check order to admin side.
         */
        await lordPage.goto("admin/sales/orders");
        await lordPage.locator(".row > div:nth-child(4) > a").first().click();
        await expect(
            lordPage.locator(".box-shadow > div:nth-child(2) > div").first()
        ).toBeVisible();
    });

    test("if not use same address for shipping", async ({ lordPage }) => {
        /**
         * Customer login.
         */
        await loginAsCustomer(lordPage);

        /**
         * Fill customer default address.
         */
        await addAddress(lordPage);

        /**
         * Go to the lord to buy a product.
         */
        await lordPage.goto("");
        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .first()
            .waitFor({ state: "visible" });
        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .nth(1)
            .waitFor({ state: "visible" });

        await lordPage
            .locator("#main div")
            .filter({ hasText: "New Products View All New" })
            .locator("button")
            .first()
            .click();
        await expect(lordPage.locator("#app")).toContainText(
            "Item Added Successfully"
        );
        await lordPage.locator(".icon-cancel").first().click();
        await lordPage.getByRole("button", { name: "shoping Cart" }).click();
        await lordPage
            .getByRole("link", { name: "Continue to Checkout" })
            .click();
        await lordPage
            .locator(
                'span[class="icon-checkout-address text-6xl text-navyBlue max-sm:text-5xl"]'
            )
            .nth(0)
            .click();

        /**
         * Disabled if not using same adress for shipping checkbox.
         */
        const isDisabled = lordPage
            .locator("#use_for_shipping")
            .nth(1)
            .uncheck();

        /**
         * If not disabled, then we disable it.
         */
        if (!isDisabled) {
            const gdprsettingToggle = lordPage
                .locator("#use_for_shipping")
                .nth(1);
            await gdprsettingToggle.waitFor({
                state: "visible",
                timeout: 5000,
            });
            await lordPage.locator("#use_for_shipping").nth(1).click();
        }

        /**
         * Verifying disable state.
         */
        const toggleInput = lordPage
            .locator("#use_for_shipping")
            .nth(1)
            .first();
        await expect(toggleInput).not.toBeChecked();

        /**
         * Add shipping address.
         */
        await lordPage
            .locator("div")
            .filter({ hasText: /^Add new address$/ })
            .nth(2)
            .click();

        await lordPage.getByRole("textbox", { name: "Company Name" }).click();
        await lordPage
            .getByRole("textbox", { name: "Company Name" })
            .fill("Webkul");
        await lordPage.getByRole("textbox", { name: "First Name" }).click();
        await lordPage.getByRole("textbox", { name: "First Name" }).fill("Sam");
        await lordPage.getByRole("textbox", { name: "Last Name" }).click();
        await lordPage
            .getByRole("textbox", { name: "Last Name" })
            .fill("LUren");
        await lordPage
            .getByRole("textbox", { name: "email@example.com" })
            .click();
        await lordPage
            .getByRole("textbox", { name: "email@example.com" })
            .fill("sam@example.com");
        await lordPage.getByRole("textbox", { name: "Street Address" }).click();
        await lordPage
            .getByRole("textbox", { name: "Street Address" })
            .fill("ARV");
        await lordPage
            .locator('select[name="shipping\\.country"]')
            .selectOption("AD");
        await lordPage.getByRole("textbox", { name: "State" }).click();
        await lordPage.getByRole("textbox", { name: "State" }).fill("any");
        await lordPage.getByRole("textbox", { name: "City" }).click();
        await lordPage.getByRole("textbox", { name: "City" }).fill("any");
        await lordPage.getByRole("textbox", { name: "Zip/Postcode" }).click();
        await lordPage
            .getByRole("textbox", { name: "Zip/Postcode" })
            .fill("123456");
        await lordPage.getByRole("textbox", { name: "Telephone" }).click();
        await lordPage
            .getByRole("textbox", { name: "Telephone" })
            .fill("123456");
        await lordPage.getByRole("button", { name: "Save" }).click();
        await lordPage.getByRole("button", { name: "Proceed" }).click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose shipping method.
         */
        await lordPage.waitForSelector("text=Free Shipping");
        await lordPage.getByText("Free Shipping").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Choose payment option.
         */
        await lordPage.waitForSelector("text=Cash On Delivery");
        await lordPage.getByText("Cash On Delivery").first().click();
        await lordPage.waitForTimeout(2000);

        /**
         * Place order.
         */
        await lordPage.getByRole("button", { name: "Place Order" }).click();
        await lordPage.waitForTimeout(2000);
        await lordPage.waitForSelector("text=Thank you for your order!");
        await expect(
            lordPage.locator("text=Thank you for your order!")
        ).toBeVisible();

        /**
         * Login to admin panel.
         */
        const adminCredentials = {
            email: "admin@example.com",
            password: "admin123",
        };
        await lordPage.goto("admin/login");
        await lordPage.getByPlaceholder("Email Address").click();
        await lordPage
            .getByPlaceholder("Email Address")
            .fill(adminCredentials.email);
        await lordPage.getByPlaceholder("Password").click();
        await lordPage
            .getByPlaceholder("Password")
            .fill(adminCredentials.password);
        await lordPage.getByRole("button", { name: "Sign In" }).click();

        /**
         * Check order to admin side.
         */
        await lordPage.goto("admin/sales/orders");
        await lordPage.locator(".row > div:nth-child(4) > a").first().click();
        await expect(
            lordPage.locator(".box-shadow > div:nth-child(2) > div").first()
        ).toBeVisible();
    });
});
