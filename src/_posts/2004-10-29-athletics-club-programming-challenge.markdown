---
layout: "post"
title: "Athletics Club Programming Challenge"
time: 23:00:00
categories:
- misc
---
A friend of mine is doing a programming course at the moment and he had this problem to solve today. He was doing it in Pascal as specified by the requirements but I was working in C# at the time and came up with this solutions. It was a nice distraction for a few minutes.

<h3>Specification</h3>

An amateur athletics club wishes to analyse its members' performances in various events. A particular requirement is for a program that will calculate the race performances of individual runners and has the following specification:

<ul>
	<li>The user will enter an unspecified number of finish times;</li>
	<li>The program must accommodate long and short races, so times will be entered in hours, minutes, seconds and hundredths of seconds;</li>
	<li>Entering a zero time will signal the end of data entry and the program will then calculate and display the:
<ul>
	<li>Fastest (i.e. smallest) time;</li>
	<li>Average of all of the times;</li>
	<li>Slowest time.</li>
</ul>
</li>
	<li>On completion of the above, the user will be offered the choice of processing further times or quitting the program.</li>
</ul>

<h3>My solution</h3>

{% highlight csharp %}
using System;

namespace DefaultNamespace
{
	class MainClass
	{
		public static void Main(string[] args)
		{
			MainClass m = new MainClass();
			while(m.Run());
		}

		public bool Run()
		{
			Int32 current = -1;
			Int32 fastest = Int32.MaxValue;
			Int32 slowest = 0;
			Int32 total = 0;
			Int32 resultcount = 0;

			Console.WriteLine("\nAthletics Club Calculator\n\nEnter all zeros to end\n");

			while (current != 0)
			{
				try
				{
					current = ToMilliseconds(GetInput("Hours"), GetInput("Minutes"), GetInput("Seconds"), GetInput("Hundreths"));
					if (current > 0)
					{
						if (current > slowest)
							slowest = current;
						if (fastest > current)
							fastest = current;
						total = total + current;
						resultcount++;
					}
					Console.WriteLine("");
				}
				catch
				{
					Console.WriteLine("Please enter whole numbers only. Starting again...");
					current = -1;
				}
			}

			if (resultcount > 0)
			{
				Console.WriteLine("Fastest: " + Display(fastest));
				Console.WriteLine("Slowest: " + Display(slowest));
				Console.WriteLine("Average: " + Display(total / resultcount));
			}
			else
				Console.WriteLine("No results were entered");

			// Run again?
			Console.Write("\nEnter another set of results? (y/n) ");
			if (Console.ReadLine().Trim().CompareTo("y") == 0)
				return true;
			return false;
		}

		private Int32 GetInput(string strPrompt)
		{
			Console.Write(strPrompt + ": ");
			return Convert.ToInt32(Console.ReadLine().Trim());
		}

		private Int32 ToMilliseconds(Int32 hours, Int32 minutes, Int32 seconds, Int32 hundreths)
		{
			return ((hours * 60 * 60 * 1000) + (minutes * 60 * 1000) + (seconds * 1000) + (hundreths * 10));
		}

		private string Display(Int32 ms)
		{
			Int32 hours, minutes, seconds, hundreths;

			minutes = ms % (60 * 60 * 1000);
			hours = ms / (60 * 60 * 1000);

			seconds = minutes % (60 * 1000);
			minutes = minutes / (60 * 1000);

			hundreths = seconds % 1000;
			seconds = seconds / 1000;

			hundreths = hundreths / 10;

			return hours.ToString("00") + ":" + minutes.ToString("00") + ":" + seconds.ToString("00") + "." + hundreths.ToString("000");
		}
	}
}
{% endhighlight %}