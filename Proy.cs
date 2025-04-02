using System;

public class Yigin<T>
{
    private T[] elemanlar;
    private int boyut;
    private int kapasite;

    public Yigin(int kapasite)
    {
        this.kapasite = kapasite;
        elemanlar = new T[kapasite];
        boyut = 0;
    }

    // Yığına eleman ekleme işlemi
    public void Ekle(T eleman)
    {
        if (boyut == kapasite)
        {
            Console.WriteLine("Yığın dolu. Eleman eklenemiyor.");
            return;
        }
        elemanlar[boyut] = eleman;
        boyut++;
    }

    // Yığından eleman çıkarma işlemi
    public T Cikar()
    {
        if (BosMu())
        {
            Console.WriteLine("Yığın boş. Eleman çıkarılamıyor.");
            return default(T);
        }
        boyut--;
        return elemanlar[boyut];
    }

    // Yığının tepesindeki elemanı gösterme işlemi
    public T Tepe()
    {
        if (BosMu())
        {
            Console.WriteLine("Yığın boş. Eleman gösterilemiyor.");
            return default(T);
        }
        return elemanlar[boyut - 1];
    }

    // Yığının boş olup olmadığını kontrol etme işlemi
    public bool BosMu()
    {
        return boyut == 0;
    }

    // Yığını ekrana yazdırma işlemi
    public void Goruntule()
    {
        if (BosMu())
        {
            Console.WriteLine("Yığın boş.");
            return;
        }
        for (int i = boyut - 1; i >= 0; i--)
        {
            Console.WriteLine(elemanlar[i]);
        }
    }
}

class Program
{
    public static void Main(string[] args)
    {
        Yigin<int> yigin = new Yigin<int>(5);

        yigin.Ekle(10);
        yigin.Ekle(20);
        yigin.Ekle(30);
        yigin.Ekle(40);
        yigin.Ekle(43);

        Console.WriteLine("Orijinal Yığın:");
        yigin.Goruntule();

        Console.WriteLine("Tepe: " + yigin.Tepe());

        Console.WriteLine("Çıkar: " + yigin.Cikar());
        yigin.Cikar();  

        Console.WriteLine("Güncellenmiş Yığın:");
        yigin.Goruntule();
        Console.ReadKey();
    }
    
}