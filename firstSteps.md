# Setup testWare workspace

## Prequisites
In order to use the testWare workspace you will need to prepare it by creating following objects:

- [Replicate your location infrastructure](#replicate-your-infrastructure) (such as buildings, rooms etc.)
- [Setup your requirements](#setup-requirements) which are applicable to your equipment
- [Generate the products](#generate-products)
- [Generate your existing equipment](#generate-equipment) from the avaliable products


### Glossary
> **Note:**
> In the following section note that if you see the phrase `domain.tld` you have to replace this with your actual domain e.g. `testware.hub.bitpack.io`

> In the context of this document the term **object** or **objects** is referencing the respective section such as location, product or company.
 
> Furthermore, the term **field** or **data-field** is referencing the data-field of the related object. The actual representation on the page may be displayed as an input field, selection menue or textfield. 

> testWare is installed with an initial set of object types such as building-type or requirement type. You may want ro edit, delete or create new types in the respective object section or in the system settings page `domain.tld/admin/systems`

## Replicate your infrastructure
The infrastructure has four layers:
- Location (your company site)
- Building (whithin your site)
- Room (within the building)
- Storage (within the room)

All objects have at least three data fields. A **label** which is required, a **name** and a **description**. The label will be used in menues and reports, so we have limited the amount of characters to 20. The *name* and *description* fields are optional.

> You can build as many objects as required. There are no limitations.

### Location
The location is your overarching area such as your factory premises, Office building or any other top level object. As an example you can use your headquarter as a location and your production plant as another. 

In order to generate a location you will need an address and a location manager. During the installation process you will be guided to generate a first location including the address and manager.

> **_Important:_ 
> It is mandatory to have at least one location generated as it will serve as a main storage, if no other location object is avaliable.**


### Building
Within each location you may place a building. You can apply one of the three initial types *office*, *workspace* and *warehouse* to arrange and order the different buildings, if necessary. The different types can be changed in the system setup page.
Buildings have additional fields such as place and a marker if the building has a goods-income capability.

As with all objects there is no limitation to the number of buildings within a location.
### Room
The next layer in the location infrastructure is the room object wich is located within a building. Similar to the building you can assign a room-type to make the room more explicit. 
### Storage
As the smallest entity the locsation object **storage** is placed within a room. Again, you can assign a storage-type to specify what kind of storage place it is. Wether it is a rach, shelf or a specific area within a room. You hava all flexibility.

## Setup requirements
testWare was made to manage the testing of the equipment whithin your company. There are many requirements and regulations for each respective type of business. To implement each one into testWare is simple not maintainable. Therefore, we deliberately left the regulation section empty. 

Following the schema from the location testWare there are three layers:
- Regulation
- Requirement
- Test step

### Regulations
Regulations represent the overarching law, directive or your own company specification. As an example the DIN VDE 0701-0702 is a regulation for the initial test of electrical equipment. 

### Requirements
Within the regulation you may specify requirements. Following the example the DIN VDE 0701-0702 differentiate between protection class I, II and III. Each protection class can be represented as a requirement. The requirement is basically a collection of test steps.

The requirement can store:

- type, a required label, a name, the interval, value and time-frame (years, months etc.) within the test steps of the requirement have to be executed, as well as a description. 

### Test steps
 A test step is a dedicated procedure to measure / verify a specific task. I require a label, a name and a description as required fields to specify the task of the test step.

#### Test equipment
Test steps may require test-equipment. If this is the case you can check the respective checkbox. Prior to the execution of the test step testWare checks for existing test-equipment and display them in a list. If no test-equipment is found, or if the existing test-equipment is locked or expired, testWare will throw an error before and hinder you to start the execution.

#### Test values
In addition to a task you can assign to measure / verify a value. You can specify the SI unit (e.g. V, A, kg, °C etc.) and the target value itself. Further you can set the condition upon which the test is passed by choosing from the *Task passes if* select field. The selection *lower than target* or *higher than target* simply check if the measured value is lower or higher than the given target.

Choosing the *Target ±tolerance* option enables you to set a specifc value as a target which has to be met in order for the test step tp pass. Specify a tolerance value and choose if the value is absolute (abs) or a percentage (%) of the target value.

You can set as many target values as required to meet the specification.

#### Test step execution
You can set if the test step can be executed internally wthin your company or if it has to be executed by an external company. You can determine multiple employees or companies respectively.

## Generate products
### Why separate products and equipment?
The basic idea is to have **products** as templates from which you can generate the actual equipment. Therefore, the amount of time to maintain central data, such as adding / removing a qualified person, is reduced significantly.

Upon creating, editing and deletion every equipment related to this product will be changed accordingly.

### Base data
The overview of all products is viewable at `domain.tld/produkt`. The base data of a product includes following data-fields:
- required label / specification
- name
- product number
- product category
- status
- equipment label

> The `product number` field is used as an identifier. The intended use is to fill in the part- oder product number of the vendor or your interal assigend product number. To view the page of the product number use the url `domain.tld/produkt/[product-number]`. In order not to break the link the data-field can only take numbers `0-9`, letters `a-Z` and special charakters `-` `_` `.`

### Parameter
Each product can be assigned with multiple parameters if necessary to extend the base data fields.  

### Requirements
You can assign multiple requirements to a

## Generate equipment
