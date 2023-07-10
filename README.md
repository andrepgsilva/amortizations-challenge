# Challenge(Goparity)

## The Heart of the Business

The domain of this business revolves around the investment in projects regarding the environmental sustainability. With that idea in mind, Goparity enables any investor(Private or an institution), doing an investment from 5€ in any projects open to funding, contributing towards the overall loan value.

More information can be found in [this page](https://goparity.com/faqs/how-do-investments-at-goparity-work).

# Tasks

## Brief Background Information

Each project is associated with a **Project Promoter** and a **Wallet** with balance. A project can have multiple amortizations.

Note: *“Amortization is the process of paying off a loan gradually over time.”*

Each amortization is associated with a ********************************************Schedule Date, Amount and a Project Id.******************************************** The amortizations can have multiples payments, and this payment has an **Amortization Id, Amount, Profile Id and State.** 

- The amortization state can be paid or pending.
- The Profile Id is the investor’s identification on the system.

**We have a board below with an overview of the process:**

![image](https://github.com/andrepgsilva/amortizations-challenge/assets/11141879/a8e1068b-b41c-465b-bf4b-e8ef5dfa153d)

## Database

Regarding the database, the “promoters” table and “profiles” table were associated to the challenge, because they can bring more consistency to our data. 

In the table “amortizations” and “payments” we are using the type BIGINT for the amount columns, taking into account that we will work with large numbers for the amounts and we will make it ready to use the **[Fixed-point arithmetic](https://en.wikipedia.org/wiki/Fixed-point_arithmetic)** technique ****for avoid floating-point problems.

Below we have an ****Entity Relationship Diagram****, just for clarification purposes****:****

![image](https://github.com/andrepgsilva/amortizations-challenge/assets/11141879/a6445c45-1c9e-45b7-91d5-4962a0307711)

## Setup
### Database Seed
- php artisan db:seed PaymentSeeder
- php artisan queue:work --queue=seed --tries=10 --sleep=3 --stop-when-empty

### Jobs
#### Process Amortizations, Payments Queues
- php artisan queue:work --timeout=10400
- php artisan queue:work --queue=amortizations tries=10 --sleep=3
- php artisan queue:work --queue=payments tries=10 --sleep=3

### Process Mail Queue
- php artisan queue:work --queue=mail-queue
